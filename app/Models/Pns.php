<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pns extends Model
{
    protected $table = 'pns';

    protected $fillable = [
        'nip',
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'nik',
        'nomor_hp',
        'email',
        'alamat',
        'npwp',
        'bpjs',
        'jenis',
        'jenis_pegawai',
        'kedudukan_hukum_nama',
        'status_cpns_pns',
        'kartu_asn_virtual',
        'nomor_sk_cpns',
        'tmt_cpns',
        'nomor_sk_pns',
        'tmt_pns',
        'gol_awal_nama',
        'gol_akhir_nama',
        'tmt_golongan',
        'mk_tahun',
        'mk_bulan',
        'jenis_jabatan',
        'eselon',
        'jabatan',
        'kategori',
        'rumpun_jabatan',
        'tmt_jabatan',
        'riwayat_diklat',
        'tingkat_pendidikan_nama',
        'pendidikan_nama',
        'tahun_lulus',
        'unor',
        'instansi_induk',
        'instansi_kerja',
        'satuan_kerja_induk',
        'satuan_kerja_kerja',
        'is_valid_nik',
    ];

    // Mapping keterangan eselon
    public static $eselonKeterangan = [
        '2A' => 'Sekretaris Daerah',
        '2B' => 'Kepala Dinas/Badan, Kepala Sekretariat DPRD',
        '3A' => 'Kepala Bagian di Sekretariat Daerah, Sekretaris Dinas/Badan, Kepala BPBD, Camat, Sekretaris Sekretariat DPRD, Direktur RSUD Sultan Suriansyah',
        '3B' => 'Kepala Bidang di Dinas/Badan, Sekretaris Camat',
        '4A' => 'Lurah, Kepala Seksi di Kecamatan, Kepala Seksi di Bagian Sekretariat Daerah, Kasubag Umum dan Kepegawaian Dinas/Badan, Kasubag Perencanaan Dinas/Badan, Kasubag Keuangan Dinas/Badan',
        '4B' => 'Kepala Seksi di Kelurahan, Kasubag Umum dan Kepegawaian di Kecamatan, Kasubag Perencanaan di Kecamatan, Kasubag Keuangan di Kecamatan',
    ];

    public function getEselonKeteranganAttribute(): string
    {
        return self::$eselonKeterangan[$this->eselon] ?? '-';
    }

    // Casting agar otomatis format sesuai tipe data
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_cpns' => 'date',
        'tmt_pns' => 'date',
        'tmt_golongan' => 'date',
        'tmt_jabatan' => 'date',
        'is_valid_nik' => 'boolean',
    ];
}
