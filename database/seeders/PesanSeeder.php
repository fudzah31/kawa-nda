<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesan;

class PesanSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        Pesan::create([
            'nip' => '123456789',
            'nama' => 'Ani Wijaya',
            'jenis_layanan' => 'Permintaan Data',
            'isi' => 'Mohon kirimkan data terbaru ke email saya.',
            'status' => 'pending', // ✅ sesuai enum
        ]);

        Pesan::create([
            'nip' => '987654321',
            'nama' => 'Budi Santoso',
            'jenis_layanan' => 'Kenaikan Pangkat',
            'isi' => 'Pengajuan kenaikan pangkat tahun ini.',
            'status' => 'selesai',
        ]);

        Pesan::create([
            'nip' => '192837465',
            'nama' => 'Citra Dewi',
            'jenis_layanan' => 'Mutasi',
            'isi' => 'Permohonan mutasi ke unit lain.',
            'status' => 'ditolak',
        ]);
    }
}
