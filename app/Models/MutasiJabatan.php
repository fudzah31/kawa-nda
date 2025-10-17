<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiJabatan extends Model
{
    use HasFactory;

    
    // Nama tabel (opsional, karena Laravel otomatis plural)
    protected $table = 'mutasi_jabatans';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama',
        'nip',
        'gol_akhir_nama',
        'jabatan',
        'unor',
        'unor_tujuan',
        'tmt_jabatan_baru',
        'sk_pelantikan',
        'berita_acara_pelantikan',
        'sk_jabatan',
        'spmt',
        'status',
    ];
}
