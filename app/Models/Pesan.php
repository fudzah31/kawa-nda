<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jenis_layanan',
        'isi',
        'status',
    ];
}
