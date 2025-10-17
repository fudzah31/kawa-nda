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
        Schema::create('kenaikan_pangkats', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->index(); 
            $table->string('nama'); // ✅ Tambahkan kolom nama
            $table->string('jabatan'); 
            $table->string('pangkat'); 
            $table->string('unor'); 
            $table->string('sk_pangkat'); 
            $table->string('spmt'); 
            $table->enum('status', ['pending', 'selesai', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kenaikan_pangkats');
    }
};
