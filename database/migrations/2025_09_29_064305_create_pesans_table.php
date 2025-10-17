<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();          // NIP user pengirim
            $table->string('nama')->nullable();         // Nama user pengirim
            $table->string('jenis_layanan');            // contoh: kenaikan_pangkat / mutasi_unor / mutasi_jabatan
            $table->text('isi');                        // isi / catatan pengajuan
            $table->enum('status', ['pending', 'selesai', 'ditolak'])->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
