<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiUnor extends Model
{
    use HasFactory;

    protected $table = 'mutasi_unors';

    protected $fillable = [
        'nama',
        'nip',
        'gol_akhir_nama',
        'jabatan',
        'unor',
        'unor_tujuan',
        'tmt_jabatan_baru',
        'sk_mutasi',
        'sk_pelantikan',
        'berita_acara_pelantikan',
        'sk_jabatan',
        'spmt',
        'status',
    ];
}
