{{-- resources/views/admin/partials/edit-pns.blade.php --}}
<div class="grid grid-cols-2 gap-4">
    @php
        $baseInput = "w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500";
        $baseTextarea = "w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500";
        $baseSelect = "w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500";
    @endphp

    {{-- 1 - 15: Identitas Dasar --}}
    <div>
        <label class="block mb-1">NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $pns->nip ?? '') }}" class="{{ $baseInput }}" required>
    </div>
    <div>
        <label class="block mb-1">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $pns->nama ?? '') }}" class="{{ $baseInput }}" required>
    </div>
    <div>
        <label class="block mb-1">Gelar Depan</label>
        <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $pns->gelar_depan ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $pns->gelar_belakang ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pns->tempat_lahir ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pns->tanggal_lahir ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="{{ $baseSelect }}">
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $pns->jenis_kelamin ?? '')=='L'?'selected':'' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $pns->jenis_kelamin ?? '')=='P'?'selected':'' }}>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block mb-1">Golongan Darah</label>
        <input type="text" name="golongan_darah" value="{{ old('golongan_darah', $pns->golongan_darah ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Agama</label>
        <input type="text" name="agama" value="{{ old('agama', $pns->agama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Status Perkawinan</label>
        <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan', $pns->status_perkawinan ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">NIK</label>
        <input type="text" name="nik" value="{{ old('nik', $pns->nik ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Nomor HP</label>
        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pns->nomor_hp ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $pns->email ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Alamat</label>
        <textarea name="alamat" class="{{ $baseTextarea }}">{{ old('alamat', $pns->alamat ?? '') }}</textarea>
    </div>
    <div>
        <label class="block mb-1">NPWP</label>
        <input type="text" name="npwp" value="{{ old('npwp', $pns->npwp ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 16 - 20 --}}
    <div>
        <label class="block mb-1">BPJS</label>
        <input type="text" name="bpjs" value="{{ old('bpjs', $pns->bpjs ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Jenis</label>
        <input type="text" name="jenis" value="{{ old('jenis', $pns->jenis ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Jenis Pegawai</label>
        <input type="text" name="jenis_pegawai" value="{{ old('jenis_pegawai', $pns->jenis_pegawai ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Kedudukan Hukum</label>
        <input type="text" name="kedudukan_hukum_nama" value="{{ old('kedudukan_hukum_nama', $pns->kedudukan_hukum_nama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Status CPNS/PNS</label>
        <input type="text" name="status_cpns_pns" value="{{ old('status_cpns_pns', $pns->status_cpns_pns ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 21 - 24 --}}
    <div>
        <label class="block mb-1">Kartu ASN Virtual</label>
        <input type="text" name="kartu_asn_virtual" value="{{ old('kartu_asn_virtual', $pns->kartu_asn_virtual ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Nomor SK CPNS</label>
        <input type="text" name="nomor_sk_cpns" value="{{ old('nomor_sk_cpns', $pns->nomor_sk_cpns ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">TMT CPNS</label>
        <input type="date" name="tmt_cpns" value="{{ old('tmt_cpns', $pns->tmt_cpns ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Nomor SK PNS</label>
        <input type="text" name="nomor_sk_pns" value="{{ old('nomor_sk_pns', $pns->nomor_sk_pns ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">TMT PNS</label>
        <input type="date" name="tmt_pns" value="{{ old('tmt_pns', $pns->tmt_pns ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 25 - 27 --}}
    <div>
        <label class="block mb-1">Golongan Awal</label>
        <input type="text" name="gol_awal_nama" value="{{ old('gol_awal_nama', $pns->gol_awal_nama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Golongan Akhir</label>
        <input type="text" name="gol_akhir_nama" value="{{ old('gol_akhir_nama', $pns->gol_akhir_nama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">TMT Golongan</label>
        <input type="date" name="tmt_golongan" value="{{ old('tmt_golongan', $pns->tmt_golongan ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 28 - 29 --}}
    <div>
        <label class="block mb-1">Masa Kerja Tahun</label>
        <input type="number" name="mk_tahun" value="{{ old('mk_tahun', $pns->mk_tahun ?? 0) }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Masa Kerja Bulan</label>
        <input type="number" name="mk_bulan" value="{{ old('mk_bulan', $pns->mk_bulan ?? 0) }}" class="{{ $baseInput }}">
    </div>

    {{-- 30 - 35 --}}
    <div>
        <label class="block mb-1">Jenis Jabatan</label>
        <input type="text" name="jenis_jabatan" value="{{ old('jenis_jabatan', $pns->jenis_jabatan ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Eselon</label>
        <input type="text" name="eselon" value="{{ old('eselon', $pns->eselon ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Jabatan</label>
        <textarea name="jabatan" class="{{ $baseTextarea }}">{{ old('jabatan', $pns->jabatan ?? '') }}</textarea>
    </div>
    <div>
        <label class="block mb-1">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $pns->kategori ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Rumpun Jabatan</label>
        <input type="text" name="rumpun_jabatan" value="{{ old('rumpun_jabatan', $pns->rumpun_jabatan ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">TMT Jabatan</label>
        <input type="date" name="tmt_jabatan" value="{{ old('tmt_jabatan', $pns->tmt_jabatan ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 36 --}}
    <div class="col-span-2">
        <label class="block mb-1">Riwayat Diklat</label>
        <textarea name="riwayat_diklat" class="{{ $baseTextarea }}">{{ old('riwayat_diklat', $pns->riwayat_diklat ?? '') }}</textarea>
    </div>

    {{-- 37 - 39 --}}
    <div>
        <label class="block mb-1">Tingkat Pendidikan</label>
        <input type="text" name="tingkat_pendidikan_nama" value="{{ old('tingkat_pendidikan_nama', $pns->tingkat_pendidikan_nama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Pendidikan</label>
        <input type="text" name="pendidikan_nama" value="{{ old('pendidikan_nama', $pns->pendidikan_nama ?? '') }}" class="{{ $baseInput }}">
    </div>
    <div>
        <label class="block mb-1">Tahun Lulus</label>
        <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $pns->tahun_lulus ?? '') }}" class="{{ $baseInput }}">
    </div>

    {{-- 40 - 44 --}}
    <div class="col-span-2">
        <label class="block mb-1">UNOR</label>
        <textarea name="unor" class="{{ $baseTextarea }}">{{ old('unor', $pns->unor ?? '') }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Instansi Induk</label>
        <textarea name="instansi_induk" class="{{ $baseTextarea }}">{{ old('instansi_induk', $pns->instansi_induk ?? '') }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Instansi Kerja</label>
        <textarea name="instansi_kerja" class="{{ $baseTextarea }}">{{ old('instansi_kerja', $pns->instansi_kerja ?? '') }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Satuan Kerja Induk</label>
        <textarea name="satuan_kerja_induk" class="{{ $baseTextarea }}">{{ old('satuan_kerja_induk', $pns->satuan_kerja_induk ?? '') }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block mb-1">Satuan Kerja Kerja</label>
        <textarea name="satuan_kerja_kerja" class="{{ $baseTextarea }}">{{ old('satuan_kerja_kerja', $pns->satuan_kerja_kerja ?? '') }}</textarea>
    </div>

    {{-- 45 --}}
    <div>
        <label class="block mb-1">Validasi NIK</label>
        <input type="checkbox" name="is_valid_nik" value="1" {{ old('is_valid_nik', $pns->is_valid_nik ?? false) ? 'checked' : '' }}>
    </div>
</div>
