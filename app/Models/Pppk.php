<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pppk extends Model
{
    protected $table = 'pppk';

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
        'npwp_nomor',   // ✅ sudah sesuai
        'bpjs',
        'jenis',
        'jenis_pegawai',
        'kedudukan_hukum',
        'status_cpns_pns',
        'kartu_asn_virtual',
        'nomor_sk_cpns',
        'tmt_cpns',
        'gol_awal',
        'gol_akhir',
        'tmt_golongan',
        'mk_tahun',
        'mk_bulan',
        'jenis_jabatan',
        'jabatan',
        'kategori',
        'rumpun_jabatan',
        'tmt_jabatan',
        'riwayat_pelatihan',
        'tingkat_pendidikan',
        'pendidikan',
        'tahun_lulus',
        'unor',
        'instansi_induk',
        'instansi_kerja',
        'satuan_kerja_induk',
        'satuan_kerja_kerja',
        'is_valid_nik',
    ];

    protected $casts = [
        'tanggal_lahir'   => 'date',
        'tmt_cpns'        => 'date',
        'tmt_golongan'    => 'date',
        'tmt_jabatan'     => 'date',
        'is_valid_nik'    => 'boolean',
    ];
}
