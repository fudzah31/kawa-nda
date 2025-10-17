    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('pns', function (Blueprint $table) {
                $table->id();

                // 1 - 15
                $table->string('nip', 50)->unique();
                $table->string('nama', 255);
                $table->string('gelar_depan', 100)->nullable();
                $table->string('gelar_belakang', 100)->nullable();
                $table->string('tempat_lahir', 150)->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('jenis_kelamin', 10)->nullable(); 
                $table->string('golongan_darah', 5)->nullable();
                $table->string('agama', 50)->nullable();
                $table->string('status_perkawinan', 50)->nullable();
                $table->string('nik', 50)->unique();
                $table->string('nomor_hp', 30)->nullable();
                $table->string('email', 150)->nullable();
                $table->text('alamat')->nullable();
                $table->string('npwp', 50)->nullable();

                // 16 - 20
                $table->string('bpjs', 50)->nullable();
                $table->string('jenis', 100)->nullable();
                $table->string('jenis_pegawai', 50)->nullable(); 
                $table->string('kedudukan_hukum_nama', 100)->nullable();
                $table->string('status_cpns_pns', 50)->nullable();

                // 21 - 24
                $table->string('kartu_asn_virtual', 100)->nullable();
                $table->string('nomor_sk_cpns', 100)->nullable();
                $table->date('tmt_cpns')->nullable();
                $table->string('nomor_sk_pns', 100)->nullable();
                $table->date('tmt_pns')->nullable();

                // 25 - 27
                $table->string('gol_awal_nama', 50)->nullable();
                $table->string('gol_akhir_nama', 50)->nullable();
                $table->date('tmt_golongan')->nullable();

                // 28 - 29
                $table->integer('mk_tahun')->default(0);
                $table->integer('mk_bulan')->default(0);

                // 30 - 35 (Jabatan + Eselon)
                $table->string('jenis_jabatan', 100)->nullable(); 
                $table->string('eselon', 10)->nullable(); 
                $table->text('jabatan')->nullable();
                $table->string('kategori', 100)->nullable();
                $table->string('rumpun_jabatan', 150)->nullable();
                $table->date('tmt_jabatan')->nullable();

                // 36
                $table->text('riwayat_diklat')->nullable();

                // 37 - 39
                $table->string('tingkat_pendidikan_nama', 100)->nullable();
                $table->string('pendidikan_nama', 150)->nullable();
                $table->year('tahun_lulus')->nullable();

                // 40 - 44
                $table->text('unor')->nullable();
                $table->text('instansi_induk')->nullable();
                $table->text('instansi_kerja')->nullable();
                $table->text('satuan_kerja_induk')->nullable();
                $table->text('satuan_kerja_kerja')->nullable();

                // 45
                $table->boolean('is_valid_nik')->default(false);

                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('pns');
        }
    };
