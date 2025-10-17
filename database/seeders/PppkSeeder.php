<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pppk;

class PppkSeeder extends Seeder
{
    public function run(): void
    {
        Pppk::create([
            'nip'               => '198001012005011001',
            'nama'              => 'Budi Santoso',
            'gelar_depan'       => 'Drs.',
            'gelar_belakang'    => 'M.Si',
            'tempat_lahir'      => 'Jakarta',
            'tanggal_lahir'     => '1980-01-01',
            'jenis_kelamin'     => 'M',
            'golongan_darah'    => 'O',
            'agama'             => 'Islam',
            'status_perkawinan' => 'Kawin',
            'nik'               => '3173010101800001',
            'nomor_hp'          => '081234567890',
            'email'             => 'budi@example.com',
            'alamat'            => 'Jl. Merdeka No. 123, Jakarta',
            'npwp_nomor'        => '12.345.678.9-012.000', // ✅ konsisten
            'bpjs'              => '9876543210',
            'jenis'             => 'PPPK',
            'jenis_pegawai'     => 'PNS SE KOTA BANJARMASIN',
            'kedudukan_hukum'   => 'Aktif',
            'status_cpns_pns'   => 'PPPK',
            'kartu_asn_virtual' => '1234567890',
            'nomor_sk_cpns'     => 'SK-PPPK-2021-001',
            'tmt_cpns'          => '2021-01-01',
            'gol_awal'          => 'III/a',
            'gol_akhir'         => 'III/b',
            'tmt_golongan'      => '2022-01-01',
            'mk_tahun'          => 2,
            'mk_bulan'          => 6,
            'jenis_jabatan'     => 'Fungsional',
            'jabatan'           => 'Analis Data',
            'kategori'          => 'Teknis',
            'rumpun_jabatan'    => 'Analis',
            'tmt_jabatan'       => '2021-01-01',
            'riwayat_pelatihan' => 'Pelatihan Data Analyst 2022',
            'tingkat_pendidikan'=> 'S2',
            'pendidikan'        => 'Ilmu Komputer',
            'tahun_lulus'       => '2005',
            'unor'              => 'Badan Pusat Statistik',
            'instansi_induk'    => 'BPS RI',
            'instansi_kerja'    => 'BPS Provinsi DKI Jakarta',
            'satuan_kerja_induk'=> 'Sekretariat Utama',
            'satuan_kerja_kerja'=> 'BPS Jakarta Pusat',
            'is_valid_nik'      => true,
        ]);
    }
}
