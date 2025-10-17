<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\Pesan;
use App\Models\KenaikanPangkat;
use App\Models\MutasiUnor;
use App\Models\MutasiJabatan;
use App\Models\Pns;
use App\Models\Pppk;
use App\Models\PengajuanUpdateProfil;

class PesanController extends Controller
{
    /**
     * 🧩 Helper untuk melengkapi data nama, nip, dan jabatan dari tabel pegawai (PNS/PPPK)
     */
    private function lengkapiDataPegawai($item)
    {
        $pegawai = null;

        // Cari berdasarkan NIP lebih dulu
        if (!empty($item->nip)) {
            $pegawai = Pns::where('nip', $item->nip)->first()
                ?? Pppk::where('nip', $item->nip)->first();
        }

        // Jika belum ketemu dan ada pegawai_id + type
        if (!$pegawai && $item->pegawai_id && $item->pegawai_type) {
            $type = strtolower($item->pegawai_type);
            if ($type === 'pns') {
                $pegawai = Pns::find($item->pegawai_id);
            } elseif ($type === 'pppk') {
                $pegawai = Pppk::find($item->pegawai_id);
            }
        }

        // Isi data ke objek jika ketemu
        if ($pegawai) {
            $item->nama = $item->nama ?? $pegawai->nama ?? '-';
            $item->nip = $item->nip ?? $pegawai->nip ?? '-';
            $item->jabatan = $item->jabatan ?? ($pegawai->jabatan ?? $pegawai->jabatan_nama ?? '-');
        } else {
            $item->nama = $item->nama ?? '-';
            $item->nip = $item->nip ?? '-';
        }

        return $item;
    }

    /**
     * 📨 Tampilkan daftar pesan & pengajuan layanan
     */
    public function index()
    {
        // 🔹 Mutasi Jabatan
        $mutasiJabatan = MutasiJabatan::latest()->get()->map(function ($item) {
            $item->jenis_layanan = 'Mutasi Jabatan';
            $item->tipe = 'mutasi_jabatan';
            return $this->lengkapiDataPegawai($item);
        });

        // 🔹 Kenaikan Pangkat
        $kenaikan = KenaikanPangkat::latest()->get()->map(function ($item) {
            $item->jenis_layanan = 'Kenaikan Pangkat';
            $item->tipe = 'kenaikan_pangkat';
            return $this->lengkapiDataPegawai($item);
        });

        // 🔹 Mutasi UNOR
        $mutasiUnor = MutasiUnor::latest()->get()->map(function ($item) {
            $item->jenis_layanan = 'Mutasi UNOR';
            $item->tipe = 'mutasi_unor';
            return $this->lengkapiDataPegawai($item);
        });

        // 🔹 Update Profil
        $updateProfil = PengajuanUpdateProfil::latest()->get()->map(function ($item) {
            $item->jenis_layanan = 'Update Profil';
            $item->tipe = 'update_profil';
            return $this->lengkapiDataPegawai($item);
        });

        // 🔹 Pesan umum
        $pesanUmum = Pesan::whereNull('jenis_layanan')
            ->orWhereNotIn('jenis_layanan', [
                'Update Profil', 'Mutasi UNOR', 'Mutasi Jabatan', 'Kenaikan Pangkat'
            ])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->jenis_layanan = $item->jenis_layanan ?? 'Pesan Umum';
                $item->tipe = 'pesan';
                return $this->lengkapiDataPegawai($item);
            });

        // 🔹 Gabungkan semua data pengajuan
        $pengajuan_layanan = collect()
            ->merge($mutasiJabatan)
            ->merge($mutasiUnor)
            ->merge($kenaikan)
            ->merge($updateProfil)
            ->merge($pesanUmum)
            ->sortByDesc('created_at')
            ->values();

        $pesan_terpilih = $pengajuan_layanan->first();

        return view('admin.pesan.index', compact('pengajuan_layanan', 'pesan_terpilih'));
    }

    /**
     * 📝 Simpan pesan atau pengajuan layanan
     */
    public function store(Request $request)
    {
        $jenis = $request->jenis_layanan;
        $userId = Auth::id();
        $nip = $request->nip;
        $nama = $request->nama;

        /**
         * 🔹 1. MUTASI JABATAN
         */
        if ($jenis === 'mutasi_jabatan') {
            $request->validate([
                'nip' => 'required|string|max:50',
                'nama' => 'required|string|max:255',
                'unor_tujuan' => 'required|string|max:255',
                'tmt_jabatan_baru' => 'nullable|date',
                'sk_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'berita_acara_pelantikan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'sk_jabatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'spmt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $data = [
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'unor_tujuan' => $request->unor_tujuan,
                'tmt_jabatan_baru' => $request->tmt_jabatan_baru,
                'status' => 'pending',
            ];

            foreach (['sk_pelantikan', 'berita_acara_pelantikan', 'sk_jabatan', 'spmt'] as $file) {
                if ($request->hasFile($file)) {
                    $data[$file] = $request->file($file)->store('mutasi_jabatan', 'public');
                }
            }

            MutasiJabatan::create($data);

            Pesan::create([
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_layanan' => 'Mutasi Jabatan',
                'isi' => "Pengajuan mutasi jabatan oleh $nama ($nip) telah dikirim dan menunggu verifikasi.",
                'status' => 'pending',
            ]);

            return back()->with('success', 'Pengajuan mutasi jabatan berhasil dikirim.');
        }

        /**
         * 🔹 2. KENAIKAN PANGKAT
         */
        if ($jenis === 'kenaikan_pangkat') {
            $request->validate([
                'nip' => 'required|string|max:50',
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'pangkat' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'sk_pangkat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'spmt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $skPangkatPath = $request->hasFile('sk_pangkat')
                ? $request->file('sk_pangkat')->store('kenaikan/sk', 'public')
                : null;

            $spmtPath = $request->hasFile('spmt')
                ? $request->file('spmt')->store('kenaikan/spmt', 'public')
                : null;

            KenaikanPangkat::create([
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'unit' => $request->unit,
                'sk_pangkat' => $skPangkatPath,
                'spmt' => $spmtPath,
                'status' => 'pending',
            ]);

            Pesan::create([
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_layanan' => 'Kenaikan Pangkat',
                'isi' => "Pengajuan kenaikan pangkat oleh $nama ($nip) telah dikirim dan menunggu verifikasi.",
                'status' => 'pending',
            ]);

            return back()->with('success', 'Pengajuan kenaikan pangkat berhasil dikirim.');
        }

        /**
         * 🔹 3. UPDATE PROFIL
         */
        if ($jenis === 'update_profil') {
            $request->validate([
                'alasan' => 'required|string|max:2000',
                'dokumen_pendukung_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
                'dokumen_pendukung_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
                'pegawai_id' => 'nullable|integer',
                'pegawai_type' => 'nullable|string',
            ]);

            $data = [
                'user_id' => $userId,
                'pegawai_id' => $request->pegawai_id,
                'pegawai_type' => $request->pegawai_type,
                'alasan' => $request->alasan,
                'status' => 'pending',
            ];

            foreach (['dokumen_pendukung_1', 'dokumen_pendukung_2'] as $dokumen) {
                if ($request->hasFile($dokumen)) {
                    $data[$dokumen] = $request->file($dokumen)->store('updateprofil', 'public');
                }
            }

            PengajuanUpdateProfil::create($data);

            Pesan::create([
                'user_id' => $userId,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_layanan' => 'Update Profil',
                'isi' => "Pengajuan update profil oleh {$request->nama} ({$request->nip}) telah dikirim dan menunggu verifikasi.",
                'status' => 'pending',
            ]);

            return back()->with('success', 'Pengajuan update profil berhasil dikirim.');
        }

        /**
         * 🔹 4. MUTASI UNOR
         */
        if ($jenis === 'mutasi_unor') {
            $request->validate([
                'nip' => 'required|string|max:50',
                'nama' => 'required|string|max:255',
                'unor_asal' => 'required|string|max:255',
                'unor_tujuan' => 'required|string|max:255',
                'sk_mutasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $data = [
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'unor_asal' => $request->unor_asal,
                'unor_tujuan' => $request->unor_tujuan,
                'status' => 'pending',
            ];

            if ($request->hasFile('sk_mutasi')) {
                $data['sk_mutasi'] = $request->file('sk_mutasi')->store('mutasi_unor', 'public');
            }

            MutasiUnor::create($data);

            Pesan::create([
                'user_id' => $userId,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_layanan' => 'Mutasi UNOR',
                'isi' => "Pengajuan mutasi UNOR oleh $nama ($nip) telah dikirim dan menunggu verifikasi.",
                'status' => 'pending',
            ]);

            return back()->with('success', 'Pengajuan mutasi UNOR berhasil dikirim.');
        }

        /**
         * 🔹 5. PESAN UMUM
         */
        if (!in_array($jenis, ['mutasi_jabatan', 'kenaikan_pangkat', 'mutasi_unor', 'update_profil'])) {
            $request->validate([
                'nip' => 'nullable|string|max:50',
                'nama' => 'required|string|max:255',
                'jenis_layanan' => 'required|string|max:100',
                'isi' => 'required|string',
            ]);

            Pesan::create([
                'user_id' => $userId,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_layanan' => $jenis,
                'isi' => $request->isi,
                'status' => 'pending',
            ]);

            return back()->with('success', 'Pesan berhasil dikirim.');
        }

        return back()->with('error', 'Jenis layanan tidak dikenali.');
    }

    /**
     * 👁️‍🗨️ Detail item
     */
    public function show(Request $request, $id)
    {
        $tipe = $request->query('tipe', 'pesan');
        $data = null;
        $pegawai = null;

        try {
            switch ($tipe) {
                case 'kenaikan_pangkat':
                    $data = KenaikanPangkat::findOrFail($id);
                    break;
                case 'mutasi_unor':
                    $data = MutasiUnor::findOrFail($id);
                    break;
                case 'mutasi_jabatan':
                    $data = MutasiJabatan::findOrFail($id);
                    break;
                case 'update_profil':
                    $data = PengajuanUpdateProfil::findOrFail($id);
                    $data->alasan = $data->alasan ?? '-';
                    break;
                default:
                    $data = Pesan::findOrFail($id);
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Gagal menampilkan detail pesan: " . $e->getMessage());
            return redirect()->route('admin.pesan.index')->with('error', 'Data tidak ditemukan.');
        }

        $data = $this->lengkapiDataPegawai($data);

        return view('admin.pesan.show', compact('data', 'tipe', 'pegawai'));
    }
/**
 * 🔄 Update status
 */
public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:pending,selesai,ditolak',
        'tipe'   => 'nullable|string'
    ]);

    $tipe   = strtolower(trim($request->tipe ?? 'pesan'));
    $status = strtolower(trim($request->status));

    try {
        $modelMap = [
            'kenaikan_pangkat' => KenaikanPangkat::class,
            'mutasi_unor'      => MutasiUnor::class,
            'mutasi_jabatan'   => MutasiJabatan::class,
            'update_profil'    => PengajuanUpdateProfil::class,
            'pesan'            => Pesan::class,
        ];

        $modelClass = $modelMap[$tipe] ?? Pesan::class;
        $model = $modelClass::findOrFail($id);
        $model->update(['status' => $status]);

        // Optional: update status pesan (jika ada relasi)
        if (method_exists($model, 'pesan')) {
            $pesan = $model->pesan;
            if ($pesan) {
                $pesan->update(['status' => $status]);
            }
        }

        return redirect()
            ->route('admin.pesan.index')
            ->with('success', "Status {$tipe} berhasil diperbarui menjadi {$status}.");
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
    }
}



    /**
     * 🗑️ Hapus item
     */
    public function destroy(Request $request, $id)
    {
        $tipe = strtolower(trim($request->tipe ?? 'pesan'));

        try {
            $modelMap = [
                'kenaikan_pangkat' => KenaikanPangkat::class,
                'mutasi_unor' => MutasiUnor::class,
                'mutasi_jabatan' => MutasiJabatan::class,
                'update_profil' => PengajuanUpdateProfil::class,
                'pesan' => Pesan::class,
            ];

            $modelClass = $modelMap[$tipe] ?? Pesan::class;
            $modelClass::findOrFail($id)->delete();

            return redirect()->route('admin.pesan.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus data: " . $e->getMessage());
            return redirect()->route('admin.pesan.index')->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * 📎 Upload lampiran file pesan
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        try {
            $data = Pesan::findOrFail($id);
            $path = $request->file('file')->store('uploads', 'public');

            if ($data->lampiran && Storage::disk('public')->exists($data->lampiran)) {
                Storage::disk('public')->delete($data->lampiran);
            }

            $data->lampiran = $path;
            $data->save();

            return redirect()
                ->route('admin.pesan.show', ['id' => $id, 'tipe' => 'pesan'])
                ->with('success', 'File berhasil diupload.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }
}
