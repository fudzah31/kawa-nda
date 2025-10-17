{{-- resources/views/admin/data/partials/edit-pppk.blade.php --}}
<div class="grid grid-cols-2 gap-4">
    {{-- 1 - 15 Identitas dasar --}}
    <div>
        <label class="block">NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $pppk->nip ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $pppk->nama ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block">Gelar Depan</label>
        <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $pppk->gelar_depan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $pppk->gelar_belakang ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pppk->tempat_lahir ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pppk->tanggal_lahir ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full border rounded p-2">
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $pppk->jenis_kelamin ?? '')=='L'?'selected':'' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $pppk->jenis_kelamin ?? '')=='P'?'selected':'' }}>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block">Golongan Darah</label>
        <input type="text" name="golongan_darah" value="{{ old('golongan_darah', $pppk->golongan_darah ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Agama</label>
        <input type="text" name="agama" value="{{ old('agama', $pppk->agama ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Status Perkawinan</label>
        <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan', $pppk->status_perkawinan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">NIK</label>
        <input type="text" name="nik" value="{{ old('nik', $pppk->nik ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block">Nomor HP</label>
        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pppk->nomor_hp ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Email</label>
        <input type="email" name="email" value="{{ old('email', $pppk->email ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div class="col-span-2">
        <label class="block">Alamat</label>
        <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $pppk->alamat ?? '') }}</textarea>
    </div>
    <div>
        <label class="block">NPWP Nomor</label>
        <input type="text" name="npwp_nomor" value="{{ old('npwp_nomor', $pppk->npwp_nomor ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 16 - 20 Kepegawaian dasar --}}
    <div>
        <label class="block">BPJS</label>
        <input type="text" name="bpjs" value="{{ old('bpjs', $pppk->bpjs ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Jenis</label>
        <input type="text" name="jenis" value="{{ old('jenis', $pppk->jenis ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Jenis Pegawai</label>
        <input type="text" name="jenis_pegawai" value="{{ old('jenis_pegawai', $pppk->jenis_pegawai ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Kedudukan Hukum</label>
        <input type="text" name="kedudukan_hukum" value="{{ old('kedudukan_hukum', $pppk->kedudukan_hukum ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Status CPNS/PNS</label>
        <input type="text" name="status_cpns_pns" value="{{ old('status_cpns_pns', $pppk->status_cpns_pns ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 21 - 23 SK & CPNS --}}
    <div>
        <label class="block">Kartu ASN Virtual</label>
        <input type="text" name="kartu_asn_virtual" value="{{ old('kartu_asn_virtual', $pppk->kartu_asn_virtual ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Nomor SK CPNS</label>
        <input type="text" name="nomor_sk_cpns" value="{{ old('nomor_sk_cpns', $pppk->nomor_sk_cpns ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">TMT CPNS</label>
        <input type="date" name="tmt_cpns" value="{{ old('tmt_cpns', $pppk->tmt_cpns ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 24 - 26 Golongan --}}
    <div>
        <label class="block">Golongan Awal</label>
        <input type="text" name="gol_awal" value="{{ old('gol_awal', $pppk->gol_awal ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Golongan Akhir</label>
        <input type="text" name="gol_akhir" value="{{ old('gol_akhir', $pppk->gol_akhir ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">TMT Golongan</label>
        <input type="date" name="tmt_golongan" value="{{ old('tmt_golongan', $pppk->tmt_golongan ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 27 - 28 Masa kerja --}}
    <div>
        <label class="block">Masa Kerja (Tahun)</label>
        <input type="number" name="mk_tahun" value="{{ old('mk_tahun', $pppk->mk_tahun ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Masa Kerja (Bulan)</label>
        <input type="number" name="mk_bulan" value="{{ old('mk_bulan', $pppk->mk_bulan ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 29 - 33 Jabatan --}}
    <div>
        <label class="block">Jenis Jabatan</label>
        <input type="text" name="jenis_jabatan" value="{{ old('jenis_jabatan', $pppk->jenis_jabatan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div class="col-span-2">
        <label class="block">Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $pppk->jabatan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $pppk->kategori ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Rumpun Jabatan</label>
        <input type="text" name="rumpun_jabatan" value="{{ old('rumpun_jabatan', $pppk->rumpun_jabatan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">TMT Jabatan</label>
        <input type="date" name="tmt_jabatan" value="{{ old('tmt_jabatan', $pppk->tmt_jabatan ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 34 Pelatihan --}}
    <div class="col-span-2">
        <label class="block">Riwayat Pelatihan</label>
        <textarea name="riwayat_pelatihan" class="w-full border rounded p-2">{{ old('riwayat_pelatihan', $pppk->riwayat_pelatihan ?? '') }}</textarea>
    </div>

    {{-- 35 - 37 Pendidikan --}}
    <div>
        <label class="block">Tingkat Pendidikan</label>
        <input type="text" name="tingkat_pendidikan" value="{{ old('tingkat_pendidikan', $pppk->tingkat_pendidikan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Pendidikan</label>
        <input type="text" name="pendidikan" value="{{ old('pendidikan', $pppk->pendidikan ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Tahun Lulus</label>
        <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $pppk->tahun_lulus ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 38 - 42 Unit Organisasi & Instansi --}}
    <div>
        <label class="block">UNOR</label>
        <input type="text" name="unor" value="{{ old('unor', $pppk->unor ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Instansi Induk</label>
        <input type="text" name="instansi_induk" value="{{ old('instansi_induk', $pppk->instansi_induk ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Instansi Kerja</label>
        <input type="text" name="instansi_kerja" value="{{ old('instansi_kerja', $pppk->instansi_kerja ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Satuan Kerja Induk</label>
        <input type="text" name="satuan_kerja_induk" value="{{ old('satuan_kerja_induk', $pppk->satuan_kerja_induk ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block">Satuan Kerja Kerja</label>
        <input type="text" name="satuan_kerja_kerja" value="{{ old('satuan_kerja_kerja', $pppk->satuan_kerja_kerja ?? '') }}" class="w-full border rounded p-2">
    </div>

    {{-- 43 Validasi NIK --}}
    <div>
        <label class="block">Validasi NIK</label>
        <select name="is_valid_nik" class="w-full border rounded p-2">
            <option value="0" {{ old('is_valid_nik', $pppk->is_valid_nik ?? 0)==0?'selected':'' }}>Tidak</option>
            <option value="1" {{ old('is_valid_nik', $pppk->is_valid_nik ?? 0)==1?'selected':'' }}>Ya</option>
        </select>
    </div>
</div>
