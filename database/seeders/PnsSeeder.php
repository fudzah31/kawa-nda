<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pns;

class PnsSeeder extends Seeder
{
    public function run(): void
    {
        Pns::create([
            'nip' => '123456789012345678',
            'nama' => 'Budi Santoso',
            'gelar_depan' => 'Drs.',
            'gelar_belakang' => 'M.Si',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-05-12',
            'jenis_kelamin' => 'M',
            'golongan_darah' => 'O',
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'nik' => '3201011205800001',
            'nomor_hp' => '081234567890',
            'email' => 'budi@example.com',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'npwp' => '12.345.678.9-012.000',
            'bpjs' => 'BPJS123456',
            'jenis' => 'PNS',
            'jenis_pegawai' => 'PNS SEKOTA BANJARMASIN',
            'kedudukan_hukum_nama' => 'Aktif',
            'status_cpns_pns' => 'PNS',
            'kartu_asn_virtual' => 'ASN123456',
            'nomor_sk_cpns' => 'SKCPNS123',
            'tmt_cpns' => '2005-01-01',
            'nomor_sk_pns' => 'SKPNS123',
            'tmt_pns' => '2006-01-01',
            'gol_awal_nama' => 'III/a',
            'gol_akhir_nama' => 'IV/b',
            'tmt_golongan' => '2020-01-01',
            'mk_tahun' => 15,
            'mk_bulan' => 6,
            'jenis_jabatan' => 'Struktural',
            'eselon' => '3A',
            'jabatan' => 'Kepala Bidang',
            'kategori' => 'Manajerial',
            'rumpun_jabatan' => 'Administrasi',
            'tmt_jabatan' => '2018-01-01',
            'riwayat_diklat' => 'Diklatpim IV, Diklat Teknis Kepegawaian',
            'tingkat_pendidikan_nama' => 'S2',
            'pendidikan_nama' => 'Ilmu Administrasi',
            'tahun_lulus' => 2004,
            'unor' => 'Bagian Kepegawaian',
            'instansi_induk' => 'Kementerian A',
            'instansi_kerja' => 'Kementerian A',
            'satuan_kerja_induk' => 'Sekretariat Jenderal',
            'satuan_kerja_kerja' => 'Biro Kepegawaian',
            'is_valid_nik' => true,
        ]);
    }
}
