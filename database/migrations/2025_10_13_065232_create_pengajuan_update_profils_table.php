<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_update_profil', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50);
            $table->string('nama_lengkap', 255);
            $table->enum('jenis_pegawai', ['PNS', 'PPPK']);
            $table->string('field_diperbarui', 100);
            $table->text('alasan')->nullable();
            $table->string('dokumen_1', 255);
            $table->string('dokumen_2', 255)->nullable();
           $table->enum('status', ['pending', 'selesai', 'ditolak'])->default('pending');
            $table->timestamps();

            $table->index('nip');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_update_profil');
    }
};
