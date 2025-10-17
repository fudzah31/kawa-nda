<?php

namespace App\Imports;

use App\Models\Pppk;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class PppkImport implements ToModel, WithHeadingRow
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
        // Log::info('Row PPPK imported:', $row);

        return new Pppk([
            'nip'                => $row['nip'] ?? null,
            'nama'               => $row['nama'] ?? null,
            'gelar_depan'        => $row['gelar_depan'] ?? null,
            'gelar_belakang'     => $row['gelar_belakang'] ?? null,
            'tempat_lahir'       => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'      => $row['tanggal_lahir'] ?? null,
            'jenis_kelamin'      => $row['jenis_kelamin'] ?? null,
            'golongan_darah'     => $row['golongan_darah'] ?? null,
            'agama'              => $row['agama'] ?? null,

            'status_perkawinan'  => $row['jenis_kawin'] ?? $row['status_perkawinan'] ?? null,

            'nik'                => $row['nik'] ?? null,
            'nomor_hp'           => $row['nomor_hp'] ?? null,
            'email'              => $row['email'] ?? null,
            'alamat'             => $row['alamat'] ?? null,

            'npwp_nomor'         => $row['npwp_nomor'] ?? $row['npwp'] ?? null,

            'bpjs'               => $row['bpjs'] ?? null,
            'jenis'              => $row['jenis'] ?? null,
            'jenis_pegawai'      => $row['jenis_pegawai'] ?? 'PPPK',
            'kedudukan_hukum'    => $row['kedudukan_hukum'] ?? $row['kedudukan_hukum_nama'] ?? null,
            'status_cpns_pns'    => $row['status_cpns_pns'] ?? null,
            'kartu_asn_virtual'  => $row['kartu_asn_virtual'] ?? null,
            'nomor_sk_cpns'      => $row['nomor_sk_cpns'] ?? null,
            'tmt_cpns'           => $row['tmt_cpns'] ?? null,
            'gol_awal'           => $row['gol_awal'] ?? null,
            'gol_akhir'          => $row['gol_akhir'] ?? null,
            'tmt_golongan'       => $row['tmt_golongan'] ?? null,
            'mk_tahun'           => $row['mk_tahun'] ?? 0,
            'mk_bulan'           => $row['mk_bulan'] ?? 0,
            'jenis_jabatan'      => $row['jenis_jabatan'] ?? null,
            'jabatan'            => $row['jabatan'] ?? null,
            'kategori'           => $row['kategori'] ?? null,
            'rumpun_jabatan'     => $row['rumpun_jabatan'] ?? null,
            'tmt_jabatan'        => $row['tmt_jabatan'] ?? null,

            'riwayat_pelatihan'  => $row['riwayat_pelatihan'] ?? $row['riwayat_diklat'] ?? null,
            'tingkat_pendidikan' => $row['tingkat_pendidikan'] ?? null,
            'pendidikan'         => $row['pendidikan'] ?? null,
            'tahun_lulus'        => $row['tahun_lulus'] ?? null,
            'unor'               => $row['unor'] ?? null,
            'instansi_induk'     => $row['instansi_induk'] ?? null,
            'instansi_kerja'     => $row['instansi_kerja'] ?? null,
            'satuan_kerja_induk' => $row['satuan_kerja_induk'] ?? null,
            'satuan_kerja_kerja' => $row['satuan_kerja_kerja'] ?? null,
            'is_valid_nik'       => isset($row['is_valid_nik']) ? (bool)$row['is_valid_nik'] : false,
        ]);
    }
}
