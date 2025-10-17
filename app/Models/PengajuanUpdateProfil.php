<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanUpdateProfil extends Model
{
    use HasFactory;

    // Nama tabel sesuai migration
    protected $table = 'pengajuan_update_profil';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jenis_pegawai',
        'field_diperbarui',
        'alasan',
        'dokumen_1',
        'dokumen_2',
        'status',
    ];

    /**
     * Relasi ke data pegawai (PNS / PPPK)
     * Berdasarkan jenis_pegawai dan nip.
     */
    public function pegawai()
    {
        if ($this->jenis_pegawai === 'PNS') {
            return $this->belongsTo(\App\Models\Pns::class, 'nip', 'nip');
        }

        return $this->belongsTo(\App\Models\Pppk::class, 'nip', 'nip');
    }

    /**
     * Scope opsional untuk filter berdasarkan user login
     * (misal kalau sistem punya tabel users dengan nip sama)
     */
    public function scopeForUser($query, $user)
    {
        return $query->where('nip', $user->nip);
    }
}
