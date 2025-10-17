<?php

namespace App\Imports;

use App\Models\Pns;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class PnsImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
        HeadingRowFormatter::extend('clean', function ($value) {
            return strtolower(str_replace(' ', '_', trim($value)));
        });

        HeadingRowFormatter::default('clean');
    }

    public function model(array $row)
    {
        // Log::info('Row imported:', $row); // uncomment untuk debugging

        return new Pns([
            'nip'                   => $row['nip'] ?? null,
            'nama'                  => $row['nama'] ?? null,
            'gelar_depan'           => $row['gelar_depan'] ?? null,
            'gelar_belakang'        => $row['gelar_belakang'] ?? null,
            'tempat_lahir'          => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'         => $row['tanggal_lahir'] ?? null,
            'jenis_kelamin'         => $row['jenis_kelamin'] ?? null,
            'golongan_darah'        => $row['golongan_darah'] ?? null,
            'agama'                 => $row['agama'] ?? null,
            'status_perkawinan'     => $row['jenis_kawin'] ?? $row['status_perkawinan'] ?? null,
            'nik'                   => $row['nik'] ?? null,
            'nomor_hp'              => $row['nomor_hp'] ?? null,
            'email'                 => $row['email'] ?? null,
            'alamat'                => $row['alamat'] ?? null,
            'npwp'                  => $row['npwp_nomor'] ?? $row['npwp'] ?? null,

            'bpjs'                  => $row['bpjs'] ?? null,
            'jenis'                 => $row['jenis'] ?? null,
            'jenis_pegawai'         => $row['jenis_pegawai'] ?? 'PNS',
            'kedudukan_hukum_nama'  => $row['kedudukan_hukum_nama'] ?? $row['kedudukan_hukum'] ?? null,
            'status_cpns_pns'       => $row['status_cpns_pns'] ?? null,

            'kartu_asn_virtual'     => $row['kartu_asn_virtual'] ?? null,
            'nomor_sk_cpns'         => $row['nomor_sk_cpns'] ?? null,
            'tmt_cpns'              => $row['tmt_cpns'] ?? null,
            'nomor_sk_pns'          => $row['nomor_sk_pns'] ?? null,
            'tmt_pns'               => $row['tmt_pns'] ?? null,

            'gol_awal_nama'         => $row['gol_awal_nama'] ?? $row['gol_awal'] ?? null,
            'gol_akhir_nama'        => $row['gol_akhir_nama'] ?? $row['gol_akhir'] ?? null,
            'tmt_golongan'          => $row['tmt_golongan'] ?? null,

            'mk_tahun'              => $row['mk_tahun'] ?? 0,
            'mk_bulan'              => $row['mk_bulan'] ?? 0,

            'jenis_jabatan'         => $row['jenis_jabatan'] ?? null,
            'jabatan'               => $row['jabatan'] ?? null,
            'kategori'              => $row['kategori'] ?? null,
            'rumpun_jabatan'        => $row['rumpun_jabatan'] ?? null,
            'tmt_jabatan'           => $row['tmt_jabatan'] ?? null,

            'riwayat_diklat'        => $row['riwayat_diklat'] ?? null,

            'tingkat_pendidikan_nama' => $row['tingkat_pendidikan_nama'] ?? $row['tingkat_pendidikan'] ?? null,
            'pendidikan_nama'         => $row['pendidikan_nama'] ?? $row['pendidikan'] ?? null,
            'tahun_lulus'             => $row['tahun_lulus'] ?? null,

            'unor'                 => $row['unor'] ?? null,
            'instansi_induk'       => $row['instansi_induk'] ?? null,
            'instansi_kerja'       => $row['instansi_kerja'] ?? null,
            'satuan_kerja_induk'   => $row['satuan_kerja_induk'] ?? null,
            'satuan_kerja_kerja'   => $row['satuan_kerja_kerja'] ?? null,

            'is_valid_nik'         => isset($row['is_valid_nik']) ? (bool)$row['is_valid_nik'] : false,
            'eselon'               => $row['eselon'] ?? null,
        ]);
    }
}
