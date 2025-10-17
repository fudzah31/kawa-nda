<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_jabatans', function (Blueprint $table) {
            $table->id();

            // Identitas Pegawai (otomatis dari user login)
            $table->string('nama');
            $table->string('nip'); // tidak unique, karena 1 nip bisa banyak permohonan
            $table->string('gol_akhir_nama', 50)->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unor');

            // Data pengajuan dari user (manual input)
            $table->string('unor_tujuan');
            $table->date('tmt_jabatan_baru')->nullable();

            // Dokumen upload
            $table->string('sk_pelantikan')->nullable();
            $table->string('berita_acara_pelantikan')->nullable();
            $table->string('sk_jabatan')->nullable();
            $table->string('spmt')->nullable();

            // Status permohonan
            $table->enum('status', ['pending', 'selesai', 'ditolak'])->default('pending');

            $table->timestamps();

            // Index hanya untuk field penting
            $table->index('nip');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_jabatans');
    }
};
