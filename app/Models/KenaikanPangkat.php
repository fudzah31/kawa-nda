<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenaikanPangkat extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional kalau sesuai konvensi).
     */
    protected $table = 'kenaikan_pangkats';

    /**
     * Kolom yang bisa diisi (mass assignable).
     */
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'pangkat',
        'unor',
        'sk_pangkat',
        'spmt',
        'status',
    ];

    /**
     * Default casting (misalnya status).
     */
    protected $casts = [
        'status' => 'string',
    ];
}
