<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pppk', function (Blueprint $table) {
            $table->id();

            // 1 - 15 (Identitas dasar)
            $table->string('nip', 50)->unique();
            $table->string('nama', 255);
            $table->string('gelar_depan', 100)->nullable();
            $table->string('gelar_belakang', 100)->nullable();
            $table->string('tempat_lahir', 150)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 10)->nullable(); // fleksibel (M/F/L/P)
            $table->string('golongan_darah', 5)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('status_perkawinan', 100)->nullable(); // string → tidak error lagi
            $table->string('nik', 50)->unique();
            $table->string('nomor_hp', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('alamat')->nullable();
            $table->string('npwp_nomor', 30)->nullable();

            // 16 - 20 (Kepegawaian dasar)
            $table->string('bpjs', 30)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->string('jenis_pegawai', 50)->nullable();
            $table->string('kedudukan_hukum', 100)->nullable();
            $table->string('status_cpns_pns', 50)->nullable();

            // 21 - 23 (SK & CPNS)
            $table->string('kartu_asn_virtual', 50)->nullable();
            $table->string('nomor_sk_cpns', 100)->nullable();
            $table->date('tmt_cpns')->nullable();

            // 24 - 26 (Golongan)
            $table->string('gol_awal', 10)->nullable();
            $table->string('gol_akhir', 10)->nullable();
            $table->date('tmt_golongan')->nullable();

            // 27 - 28 (Masa kerja)
            $table->integer('mk_tahun')->default(0)->nullable();
            $table->integer('mk_bulan')->default(0)->nullable();

            // 29 - 33 (Jabatan)
            $table->string('jenis_jabatan', 100)->nullable();
            $table->string('jabatan', 150)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('rumpun_jabatan', 100)->nullable();
            $table->date('tmt_jabatan')->nullable();

            // 34 (Pelatihan)
            $table->text('riwayat_pelatihan')->nullable();

            // 35 - 37 (Pendidikan)
            $table->string('tingkat_pendidikan', 50)->nullable();
            $table->string('pendidikan', 150)->nullable();
            $table->year('tahun_lulus')->nullable();

            // 38 - 42 (Unit Organisasi & Instansi)
            $table->string('unor', 150)->nullable();
            $table->string('instansi_induk', 150)->nullable();
            $table->string('instansi_kerja', 150)->nullable();
            $table->string('satuan_kerja_induk', 150)->nullable();
            $table->string('satuan_kerja_kerja', 150)->nullable();

            // 43 (Validasi NIK)
            $table->boolean('is_valid_nik')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pppk');
    }
};
