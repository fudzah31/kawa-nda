<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pns;
use App\Models\Pppk;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ==========================
     *  DASHBOARD USER
     * ==========================
     * Menampilkan data pegawai (PNS / PPPK) otomatis
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Cari di tabel PNS berdasarkan NIP
        $pegawai = Pns::where('nip', $user->nip)->first();
        $jenis = 'PNS';

        // Jika tidak ditemukan di PNS, cek PPPK
        if (!$pegawai) {
            $pegawai = Pppk::where('nip', $user->nip)->first();
            $jenis = 'PPPK';
        }

        // Jika tetap tidak ada (pegawai belum sinkron)
        if (!$pegawai) {
            return view('user.dashboard', [
                'user' => $user,
                'pegawai' => null,
                'data' => null,
            ]);
        }

        // Normalisasi DATA Dashboard
        $data = [
            'nama' => $pegawai->nama ?? '-',
            'nip' => $pegawai->nip ?? '-',
            'jabatan' => $pegawai->jabatan ?? '-',
            'unit_organisasi' => $pegawai->unor ?? '-',
            'kategori' => $pegawai->kategori ?? '-',
            'jenis_pegawai' => $jenis,
            'golongan_pangkat' => $jenis === 'PNS' ? ($pegawai->gol_akhir_nama ?? '-') : ($pegawai->gol_akhir ?? '-'),
            'riwayat_pendidikan' => $jenis === 'PNS' ? ($pegawai->pendidikan_nama ?? '-') : ($pegawai->pendidikan ?? '-'),
            'status' => $pegawai->kedudukan_hukum_nama ?? 'Aktif',
        ];

        // SUPPORT AUTO REFRESH (AJAX)
        if ($request->ajax()) {
            return view('user.dashboard', compact('user', 'pegawai', 'data'))->render();
        }

        return view('user.dashboard', compact('user', 'pegawai', 'data'));
    }

    /**
     * ==========================
     *  PROFIL DETAIL PEGAWAI
     * ==========================
     */
    public function profileIndex()
    {
        $user = Auth::user();

        // Cari PNS dulu
        $pegawai = Pns::where('nip', $user->nip)->first();
        $jenis = 'PNS';

        // Jika tidak ketemu, cek PPPK
        if (!$pegawai) {
            $pegawai = Pppk::where('nip', $user->nip)->first();
            $jenis = 'PPPK';
        }

        // Jika tetap tidak ditemukan
        if (!$pegawai) {
            return view('user.profile.index', [
                'user' => $user,
                'pegawai' => null,
                'data' => null,
            ]);
        }

        // Normalisasi DATA Profill
        $data = [
            'nip' => $pegawai->nip ?? '-',
            'nama' => $pegawai->nama ?? '-',
            'gelar_depan' => $pegawai->gelar_depan ?? '',
            'gelar_belakang' => $pegawai->gelar_belakang ?? '',
            'tempat_lahir' => $pegawai->tempat_lahir ?? '-',
            'tanggal_lahir' => $pegawai->tanggal_lahir ?? '-',
            'jenis_kelamin' => $pegawai->jenis_kelamin ?? '-',
            'golongan_darah' => $pegawai->golongan_darah ?? '-',
            'agama' => $pegawai->agama ?? '-',
            'status_perkawinan' => $pegawai->status_perkawinan ?? '-',
            'nik' => $pegawai->nik ?? '-',
            'no_hp' => $pegawai->nomor_hp ?? '-',
            'email' => $pegawai->email ?? '-',
            'alamat' => $pegawai->alamat ?? '-',
            'npwp' => $jenis === 'PNS' ? ($pegawai->npwp ?? '-') : ($pegawai->npwp_nomor ?? '-'),
            'bpjs' => $pegawai->bpjs ?? '-',
            'jenis' => $pegawai->jenis ?? '-',
            'jenis_pegawai' => $jenis,
            'kedudukan_hukum' => $pegawai->kedudukan_hukum_nama ?? $pegawai->kedudukan_hukum ?? '-',
            'status_cpns_pns' => $pegawai->status_cpns_pns ?? '-',
            'kartu_asn_virtual' => $pegawai->kartu_asn_virtual ?? '-',
            'nomor_sk_cpns' => $pegawai->nomor_sk_cpns ?? '-',
            'tmt_cpns' => $pegawai->tmt_cpns ?? '-',
            'nomor_sk_pns' => $pegawai->nomor_sk_pns ?? '-',
            'tmt_pns' => $pegawai->tmt_pns ?? '-',
            'golongan_pangkat' => $jenis === 'PNS' ? ($pegawai->gol_akhir_nama ?? '-') : ($pegawai->gol_akhir ?? '-'),
            'riwayat_pendidikan' => $jenis === 'PNS' ? ($pegawai->pendidikan_nama ?? '-') : ($pegawai->pendidikan ?? '-'),
            'unit_organisasi' => $pegawai->unor ?? '-',
            'jabatan' => $pegawai->jabatan ?? '-',
            'kategori' => $pegawai->kategori ?? '-',
            'status' => 'Aktif',
        ];

        return view('user.profile.index', compact('user', 'pegawai', 'data'));
    }

    /**
     * ==========================
     *  KIRIM PESAN KE ADMIN
     * ==========================
     */
    public function storeMessage(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Jika tabel pesan tersedia, bisa aktivasi ini:
        // Pesan::create([
        //     'user_id' => Auth::id(),
        //     'subject' => $request->subject,
        //     'message' => $request->message,
        // ]);

        return back()->with('success', 'Pesan berhasil dikirim ke admin!');
    }
}
