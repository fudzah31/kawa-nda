<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

use App\Models\MutasiUnor;
use App\Models\MutasiJabatan;
use App\Models\User;
use App\Models\Pesan;
use App\Models\Pns;
use App\Models\Pppk;
use App\Models\KenaikanPangkat;
use App\Models\PengajuanUpdateProfil;

class UserLayananController extends Controller
{
    // =========================================================
    // INDEX — Halaman utama daftar layanan & pengajuan user
    // =========================================================
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $layanans = [
            ['id' => 'kenaikan-pangkat', 'nama' => 'Kenaikan Pangkat', 'deskripsi' => 'Ajukan permohonan kenaikan pangkat pegawai.'],
            ['id' => 'mutasi-unor', 'nama' => 'Mutasi UNOR', 'deskripsi' => 'Ajukan mutasi antar unit organisasi.'],
            ['id' => 'mutasi-jabatan', 'nama' => 'Mutasi Jabatan', 'deskripsi' => 'Ajukan perubahan jabatan.'],
            ['id' => 'update-profil', 'nama' => 'Update Profil', 'deskripsi' => 'Perbarui data profil pribadi Anda.'],
        ];

        $nip = $user->nip ?? null;
        $pengajuans = collect();

        if ($nip) {
            $pengajuans = collect()
                ->merge(KenaikanPangkat::where('nip', $nip)->get()->each->setAttribute('jenis_layanan', 'Kenaikan Pangkat'))
                ->merge(MutasiUnor::where('nip', $nip)->get()->each->setAttribute('jenis_layanan', 'Mutasi UNOR'))
                ->merge(MutasiJabatan::where('nip', $nip)->get()->each->setAttribute('jenis_layanan', 'Mutasi Jabatan'))
                ->merge(PengajuanUpdateProfil::where('nip', $nip)->get()->each->setAttribute('jenis_layanan', 'Update Profil'));
        }

        $pengajuans = $pengajuans->sortByDesc(fn($i) => $i->created_at ?? now())->values();

        return view('user.layanan.index', compact('layanans', 'pengajuans'));
    }

    // =========================================================
    // FORM VIEW — Halaman form tiap layanan
    // =========================================================
    public function kenaikanPangkat()
    {
        return view('user.layanan.kenaikan-pangkat');
    }

    public function mutasiUnor()
    {
        $user = Auth::user();
        return view('user.layanan.mutasi-unor', [
            'pegawai' => $this->getPegawaiByUser($user),
            'listPegawai' => $this->getPegawaiListByUser($user),
        ]);
    }

    public function mutasiJabatan()
    {
        $user = Auth::user();
        return view('user.layanan.mutasi-jabatan', [
            'pegawai' => $this->getPegawaiByUser($user),
            'listPegawai' => $this->getPegawaiListByUser($user),
        ]);
    }

    public function updateProfil()
    {
        $user = Auth::user();
        $pegawai = $this->getPegawaiByUser($user);
        $listPegawai = $this->getPegawaiListByUser($user);
        $jenisPegawai = $pegawai instanceof Pns ? 'PNS' : ($pegawai instanceof Pppk ? 'PPPK' : 'Pegawai');

        return view('user.layanan.update-profil', compact('pegawai', 'listPegawai', 'jenisPegawai'));
    }

    // =========================================================
    // STORE — Kenaikan Pangkat
    // =========================================================
    public function storeKenaikanPangkat(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:50',
            'nama' => 'required_without:nama_lengkap|string|max:255',
            'nama_lengkap' => 'required_without:nama|string|max:255',
            'jabatan' => 'required|string|max:100',
            'pangkat' => 'required|string|max:100',
            'unor' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:100',
            'sk_pangkat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spmt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        try {
            $user = Auth::user();
            $folder = "kenaikan-pangkat/{$user->id}";
            $nip = $request->nip;
            $nama = $request->nama ?? $request->nama_lengkap;
            $unor = $request->unor ?? $request->unit ?? '-';

            $paths = [
                'sk_pangkat' => $request->file('sk_pangkat')?->store($folder, 'public'),
                'spmt' => $request->file('spmt')?->store($folder, 'public'),
            ];

            KenaikanPangkat::create([
                'user_id' => Auth::id(),
                'nip' => $nip,
                'nama' => $nama,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'unor' => $unor,
                'unit' => $unor,
                'sk_pangkat' => $paths['sk_pangkat'] ?? null,
                'spmt' => $paths['spmt'] ?? null,
                'status' => 'pending',
            ]);

            $this->createPesanIfNotExists($nip, $nama, 'Kenaikan Pangkat', 'Mengajukan permohonan kenaikan pangkat.');
            return redirect()->route('user.layanan.index')->with('success', '✅ Pengajuan kenaikan pangkat berhasil diajukan.');
        } catch (\Throwable $e) {
            Log::error('❌ Error menyimpan kenaikan pangkat: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan.')->withInput();
        }
    }

    // =========================================================
    // STORE — Mutasi UNOR
    // =========================================================
    public function storeMutasiUnor(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();
        $pegawai = $this->getPegawaiByUser($user);
        $nip = $user->nip ?? ($pegawai->nip ?? null);
        $nama = $pegawai->nama ?? $user->name;

        $validator = Validator::make($request->all(), [
            'unor_tujuan' => 'required|string|max:150',
            'tmt_jabatan_baru' => 'required|date',
            'sk_mutasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_jabatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spmt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berita_acara_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        try {
            $folder = "mutasi-unor/{$user->id}";
            $paths = [];
            foreach (['sk_mutasi', 'sk_jabatan', 'spmt', 'sk_pelantikan', 'berita_acara_pelantikan'] as $f) {
                $paths[$f] = $request->file($f)?->store($folder, 'public');
            }

            MutasiUnor::create(array_merge([
                'user_id' => $user->id,
                'nama' => $nama,
                'nip' => $nip,
                'gol_akhir_nama' => $pegawai->gol_akhir_nama ?? null,
                'jabatan' => $pegawai->jabatan_nama ?? $pegawai->jabatan ?? null,
                'unor' => $pegawai->unor ?? null,
                'unor_tujuan' => $request->unor_tujuan,
                'tmt_jabatan_baru' => $request->tmt_jabatan_baru,
                'status' => 'pending',
            ], $paths));

            $this->createPesanIfNotExists($nip, $nama, 'Mutasi UNOR', 'Mengajukan mutasi ke UNOR tujuan: ' . $request->unor_tujuan);
            return redirect()->route('user.layanan.index')->with('success', 'Permohonan mutasi UNOR berhasil diajukan.');
        } catch (\Throwable $e) {
            Log::error('Error menyimpan mutasi UNOR: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan permohonan mutasi UNOR.');
        }
    }

    // =========================================================
    // STORE — Mutasi Jabatan
    // =========================================================
    public function storeMutasiJabatan(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();
        $pegawai = $this->getPegawaiByUser($user);
        $nip = $user->nip ?? ($pegawai->nip ?? null);
        $nama = $pegawai->nama ?? $user->name;

        $validator = Validator::make($request->all(), [
            'unor_tujuan' => 'required|string|max:150',
            'tmt_jabatan_baru' => 'required|date',
            'sk_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berita_acara_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_jabatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spmt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        try {
            $folder = "mutasi-jabatan/{$user->id}";
            $paths = [];
            foreach (['sk_pelantikan', 'berita_acara_pelantikan', 'sk_jabatan', 'spmt'] as $f) {
                $paths[$f] = $request->file($f)?->store($folder, 'public');
            }

            MutasiJabatan::create(array_merge([
                'user_id' => $user->id,
                'nama' => $nama,
                'nip' => $nip,
                'gol_akhir_nama' => $pegawai->gol_akhir_nama ?? null,
                'jabatan' => $pegawai->jabatan_nama ?? $pegawai->jabatan ?? null,
                'unor' => $pegawai->unor ?? null,
                'unor_tujuan' => $request->unor_tujuan,
                'tmt_jabatan_baru' => $request->tmt_jabatan_baru,
                'status' => 'pending',
            ], $paths));

            $this->createPesanIfNotExists($nip, $nama, 'Mutasi Jabatan', 'Mengajukan mutasi jabatan ke UNOR tujuan: ' . $request->unor_tujuan);
            return redirect()->route('user.layanan.index')->with('success', 'Permohonan mutasi jabatan berhasil diajukan.');
        } catch (\Throwable $e) {
            Log::error('Error menyimpan mutasi jabatan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan permohonan mutasi jabatan.');
        }
    }

    // =========================================================
    // STORE — Update Profil
    // =========================================================
    public function storeUpdateProfil(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();
        $pegawai = $this->getPegawaiByUser($user);

        if (!$pegawai && $request->filled(['pegawai_id', 'pegawai_type'])) {
            $pegawai = strtolower($request->pegawai_type) === 'pns'
                ? Pns::find($request->pegawai_id)
                : Pppk::find($request->pegawai_id);
        }

        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $cekPending = PengajuanUpdateProfil::where('nip', $pegawai->nip)
            ->where('status', 'pending')
            ->exists();

        if ($cekPending) {
            return back()->with('error', 'Anda sudah memiliki pengajuan update profil yang masih diproses.');
        }

        $request->validate([
            'field_diperbarui' => 'required|string|max:100',
            'alasan' => 'required|string|max:2000',
            'dokumen_1' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'dokumen_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        try {
            $folder = "update-profil/{$user->id}";
            $dok1 = $request->file('dokumen_1')?->store($folder, 'public');
            $dok2 = $request->file('dokumen_2')?->store($folder, 'public');

            PengajuanUpdateProfil::create([
                'nip' => $pegawai->nip,
                'nama_lengkap' => $pegawai->nama,
                'jenis_pegawai' => ($pegawai instanceof Pns) ? 'PNS' : 'PPPK',
                'field_diperbarui' => $request->field_diperbarui,
                'alasan' => $request->alasan,
                'dokumen_1' => $dok1,
                'dokumen_2' => $dok2,
                'status' => 'pending',
            ]);

            $this->createPesanIfNotExists($pegawai->nip, $pegawai->nama, 'Update Profil', $request->alasan);
            return redirect()->route('user.layanan.index')->with('success', 'Pengajuan update profil berhasil diajukan.');
        } catch (\Throwable $e) {
            Log::error('Error menyimpan update profil: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengajukan update profil.');
        }
    }

    // =========================================================
    // HELPER FUNCTIONS
    // =========================================================
    private function getPegawaiByUser($user)
    {
        if ($user && $user->nip) {
            return Pns::where('nip', $user->nip)->first()
                ?? Pppk::where('nip', $user->nip)->first();
        }
        return null;
    }

    private function getPegawaiListByUser($user)
    {
        if ($user && $user->nip) {
            return Pns::where('nip', $user->nip)->get()
                ->merge(Pppk::where('nip', $user->nip)->get());
        }
        return collect();
    }

    private function createPesanIfNotExists(?string $nip, ?string $nama, string $jenis, string $isi)
    {
        $query = Pesan::where('jenis_layanan', $jenis);
        $nip ? $query->where('nip', $nip) : $query->whereNull('nip');
        $exists = $query->whereDate('created_at', now()->toDateString())->exists();

        if (!$exists) {
            Pesan::create([
                'nip' => $nip,
                'nama' => $nama,
                'jenis_layanan' => $jenis,
                'isi' => $isi,
                'status' => 'pending',
            ]);
        } else {
            Log::info("Pesan duplikat dicegah untuk NIP {$nip} dan layanan {$jenis}");
        }
    }

    // =========================================================
    // DESTROY MULTIPLE — Hapus banyak pengajuan sekaligus
    // =========================================================
    public function destroyMultiple(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $models = [
            KenaikanPangkat::class,
            MutasiUnor::class,
            MutasiJabatan::class,
            PengajuanUpdateProfil::class,
            Pesan::class
        ];

        try {
            foreach ($models as $model) {
                $instance = new $model;
                $table = $instance->getTable();

                $query = $model::whereIn('id', $ids);

                $hasUserId = Schema::hasColumn($table, 'user_id');
                $hasNip = Schema::hasColumn($table, 'nip');

                if ($hasUserId || $hasNip) {
                    $query->where(function ($q) use ($hasUserId, $hasNip, $user) {
                        if ($hasUserId) $q->where('user_id', $user->id);
                        if ($hasNip) $q->orWhere('nip', $user->nip);
                    });
                } else {
                    continue;
                }

                $items = $query->get();
                foreach ($items as $item) {
                    foreach ($item->getAttributes() as $field => $value) {
                        if (is_string($value) && str_contains($value, 'storage/')) {
                            Storage::disk('public')->delete($value);
                        }
                    }
                    $item->delete();
                }
            }

            return redirect()->back()->with('success', 'Data terpilih berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Error hapus multiple data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
