{{-- resources/views/admin/data/partials/form-fields.blade.php --}}

{{-- NIP --}}
<div>
    <label class="block font-medium">NIP</label>
    <input type="text" name="nip" class="border rounded w-full p-2"
           value="{{ old('nip', $pns->nip ?? '') }}" required>
</div>

{{-- Nama --}}
<div>
    <label class="block font-medium">Nama</label>
    <input type="text" name="nama" class="border rounded w-full p-2"
           value="{{ old('nama', $pns->nama ?? '') }}" required>
</div>

{{-- Gelar Depan --}}
<div>
    <label class="block font-medium">Gelar Depan</label>
    <input type="text" name="gelar_depan" class="border rounded w-full p-2"
           value="{{ old('gelar_depan', $pns->gelar_depan ?? '') }}">
</div>

{{-- Gelar Belakang --}}
<div>
    <label class="block font-medium">Gelar Belakang</label>
    <input type="text" name="gelar_belakang" class="border rounded w-full p-2"
           value="{{ old('gelar_belakang', $pns->gelar_belakang ?? '') }}">
</div>

{{-- Tempat Lahir --}}
<div>
    <label class="block font-medium">Tempat Lahir</label>
    <input type="text" name="tempat_lahir" class="border rounded w-full p-2"
           value="{{ old('tempat_lahir', $pns->tempat_lahir ?? '') }}">
</div>

{{-- Tanggal Lahir --}}
<div>
    <label class="block font-medium">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" class="border rounded w-full p-2"
           value="{{ old('tanggal_lahir', $pns->tanggal_lahir ?? '') }}">
</div>

{{-- Jenis Kelamin --}}
<div>
    <label class="block font-medium">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="border rounded w-full p-2">
        <option value="">-- Pilih --</option>
        <option value="M" {{ old('jenis_kelamin', $pns->jenis_kelamin ?? '') == 'M' ? 'selected' : '' }}>Laki-laki</option>
        <option value="F" {{ old('jenis_kelamin', $pns->jenis_kelamin ?? '') == 'F' ? 'selected' : '' }}>Perempuan</option>
    </select>
</div>

{{-- Golongan Darah --}}
<div>
    <label class="block font-medium">Golongan Darah</label>
    <select name="golongan_darah" class="border rounded w-full p-2">
        <option value="">-- Pilih --</option>
        @foreach(['A','B','AB','O'] as $gol)
            <option value="{{ $gol }}" {{ old('golongan_darah', $pns->golongan_darah ?? '') == $gol ? 'selected' : '' }}>{{ $gol }}</option>
        @endforeach
    </select>
</div>

{{-- Agama --}}
<div>
    <label class="block font-medium">Agama</label>
    <select name="agama" class="border rounded w-full p-2">
        <option value="">-- Pilih --</option>
        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agm)
            <option value="{{ $agm }}" {{ old('agama', $pns->agama ?? '') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
        @endforeach
    </select>
</div>

{{-- Status Perkawinan --}}
<div>
    <label class="block font-medium">Status Perkawinan</label>
    <select name="status_perkawinan" class="border rounded w-full p-2">
        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)
            <option value="{{ $status }}" {{ old('status_perkawinan', $pns->status_perkawinan ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>

{{-- NIK --}}
<div>
    <label class="block font-medium">NIK</label>
    <input type="text" name="nik" class="border rounded w-full p-2"
           value="{{ old('nik', $pns->nik ?? '') }}" required>
</div>

{{-- Nomor HP --}}
<div>
    <label class="block font-medium">Nomor HP</label>
    <input type="text" name="nomor_hp" class="border rounded w-full p-2"
           value="{{ old('nomor_hp', $pns->nomor_hp ?? '') }}">
</div>

{{-- Email --}}
<div>
    <label class="block font-medium">Email</label>
    <input type="email" name="email" class="border rounded w-full p-2"
           value="{{ old('email', $pns->email ?? '') }}">
</div>

{{-- Alamat --}}
<div class="md:col-span-2">
    <label class="block font-medium">Alamat</label>
    <textarea name="alamat" class="border rounded w-full p-2">{{ old('alamat', $pns->alamat ?? '') }}</textarea>
</div>

{{-- NPWP --}}
<div>
    <label class="block font-medium">NPWP</label>
    <input type="text" name="npwp" class="border rounded w-full p-2"
           value="{{ old('npwp', $pns->npwp ?? '') }}">
</div>

{{-- BPJS --}}
<div>
    <label class="block font-medium">BPJS</label>
    <input type="text" name="bpjs" class="border rounded w-full p-2"
           value="{{ old('bpjs', $pns->bpjs ?? '') }}">
</div>

{{-- Jenis --}}
<div>
    <label class="block font-medium">Jenis</label>
    <input type="text" name="jenis" class="border rounded w-full p-2"
           value="{{ old('jenis', $pns->jenis ?? '') }}">
</div>

{{-- Jenis Pegawai --}}
<div>
    <label class="block font-medium">Jenis Pegawai</label>
    <input type="text" name="jenis_pegawai" class="border rounded w-full p-2"
           value="{{ old('jenis_pegawai', $pns->jenis_pegawai ?? '') }}">
</div>

{{-- Kedudukan Hukum --}}
<div>
    <label class="block font-medium">Kedudukan Hukum</label>
    <input type="text" name="kedudukan_hukum_nama" class="border rounded w-full p-2"
           value="{{ old('kedudukan_hukum_nama', $pns->kedudukan_hukum_nama ?? '') }}">
</div>

{{-- Status CPNS/PNS --}}
<div>
    <label class="block font-medium">Status CPNS/PNS</label>
    <input type="text" name="status_cpns_pns" class="border rounded w-full p-2"
           value="{{ old('status_cpns_pns', $pns->status_cpns_pns ?? '') }}">
</div>

{{-- Kartu ASN Virtual --}}
<div>
    <label class="block font-medium">Kartu ASN Virtual</label>
    <input type="text" name="kartu_asn_virtual" class="border rounded w-full p-2"
           value="{{ old('kartu_asn_virtual', $pns->kartu_asn_virtual ?? '') }}">
</div>

{{-- Nomor SK CPNS --}}
<div>
    <label class="block font-medium">Nomor SK CPNS</label>
    <input type="text" name="nomor_sk_cpns" class="border rounded w-full p-2"
           value="{{ old('nomor_sk_cpns', $pns->nomor_sk_cpns ?? '') }}">
</div>

{{-- TMT CPNS --}}
<div>
    <label class="block font-medium">TMT CPNS</label>
    <input type="date" name="tmt_cpns" class="border rounded w-full p-2"
           value="{{ old('tmt_cpns', $pns->tmt_cpns ?? '') }}">
</div>

{{-- Nomor SK PNS --}}
<div>
    <label class="block font-medium">Nomor SK PNS</label>
    <input type="text" name="nomor_sk_pns" class="border rounded w-full p-2"
           value="{{ old('nomor_sk_pns', $pns->nomor_sk_pns ?? '') }}">
</div>

{{-- TMT PNS --}}
<div>
    <label class="block font-medium">TMT PNS</label>
    <input type="date" name="tmt_pns" class="border rounded w-full p-2"
           value="{{ old('tmt_pns', $pns->tmt_pns ?? '') }}">
</div>

{{-- Golongan Awal --}}
<div>
    <label class="block font-medium">Golongan Awal</label>
    <input type="text" name="gol_awal_nama" class="border rounded w-full p-2"
           value="{{ old('gol_awal_nama', $pns->gol_awal_nama ?? '') }}">
</div>

{{-- Golongan Akhir --}}
<div>
    <label class="block font-medium">Golongan Akhir</label>
    <input type="text" name="gol_akhir_nama" class="border rounded w-full p-2"
           value="{{ old('gol_akhir_nama', $pns->gol_akhir_nama ?? '') }}">
</div>

{{-- TMT Golongan --}}
<div>
    <label class="block font-medium">TMT Golongan</label>
    <input type="date" name="tmt_golongan" class="border rounded w-full p-2"
           value="{{ old('tmt_golongan', $pns->tmt_golongan ?? '') }}">
</div>

{{-- Masa Kerja --}}
<div>
    <label class="block font-medium">Masa Kerja (Tahun)</label>
    <input type="number" name="mk_tahun" class="border rounded w-full p-2"
           value="{{ old('mk_tahun', $pns->mk_tahun ?? 0) }}">
</div>
<div>
    <label class="block font-medium">Masa Kerja (Bulan)</label>
    <input type="number" name="mk_bulan" class="border rounded w-full p-2"
           value="{{ old('mk_bulan', $pns->mk_bulan ?? 0) }}">
</div>

{{-- Jenis Jabatan --}}
<div>
    <label class="block font-medium">Jenis Jabatan</label>
    <select id="jenis_jabatan" name="jenis_jabatan" class="border rounded w-full p-2">
        <option value="">-- Pilih --</option>
        @foreach(['Struktural','Fungsional','Pelaksana'] as $jj)
            <option value="{{ $jj }}" {{ old('jenis_jabatan', $pns->jenis_jabatan ?? '') == $jj ? 'selected' : '' }}>{{ $jj }}</option>
        @endforeach
    </select>
</div>

{{-- Jabatan --}}
<div>
    <label class="block font-medium">Jabatan</label>
    <textarea name="jabatan" class="border rounded w-full p-2">{{ old('jabatan', $pns->jabatan ?? '') }}</textarea>
</div>

{{-- Eselon --}}
<div id="eselonField">
    <label class="block font-medium">Eselon</label>
    <select name="eselon" class="border rounded w-full p-2">
        <option value="">-- Pilih --</option>
        @foreach(['2A','2B','3A','3B','4A','4B'] as $e)
            <option value="{{ $e }}" {{ old('eselon', $pns->eselon ?? '') == $e ? 'selected' : '' }}>{{ $e }}</option>
        @endforeach
    </select>
</div>

{{-- Kategori --}}
<div>
    <label class="block font-medium">Kategori</label>
    <input type="text" name="kategori" class="border rounded w-full p-2"
           value="{{ old('kategori', $pns->kategori ?? '') }}">
</div>

{{-- Rumpun Jabatan --}}
<div>
    <label class="block font-medium">Rumpun Jabatan</label>
    <input type="text" name="rumpun_jabatan" class="border rounded w-full p-2"
           value="{{ old('rumpun_jabatan', $pns->rumpun_jabatan ?? '') }}">
</div>

{{-- TMT Jabatan --}}
<div>
    <label class="block font-medium">TMT Jabatan</label>
    <input type="date" name="tmt_jabatan" class="border rounded w-full p-2"
           value="{{ old('tmt_jabatan', $pns->tmt_jabatan ?? '') }}">
</div>

{{-- Riwayat Diklat --}}
<div class="md:col-span-2">
    <label class="block font-medium">Riwayat Diklat</label>
    <textarea name="riwayat_diklat" class="border rounded w-full p-2">{{ old('riwayat_diklat', $pns->riwayat_diklat ?? '') }}</textarea>
</div>

{{-- Tingkat Pendidikan --}}
<div>
    <label class="block font-medium">Tingkat Pendidikan</label>
    <input type="text" name="tingkat_pendidikan_nama" class="border rounded w-full p-2"
           value="{{ old('tingkat_pendidikan_nama', $pns->tingkat_pendidikan_nama ?? '') }}">
</div>

{{-- Pendidikan --}}
<div>
    <label class="block font-medium">Pendidikan</label>
    <input type="text" name="pendidikan_nama" class="border rounded w-full p-2"
           value="{{ old('pendidikan_nama', $pns->pendidikan_nama ?? '') }}">
</div>

{{-- Tahun Lulus --}}
<div>
    <label class="block font-medium">Tahun Lulus</label>
    <input type="text" name="tahun_lulus" class="border rounded w-full p-2"
           value="{{ old('tahun_lulus', $pns->tahun_lulus ?? '') }}">
</div>

{{-- Unit Organisasi --}}
<div>
    <label class="block font-medium">Unit Organisasi</label>
    <textarea name="unor" class="border rounded w-full p-2">{{ old('unor', $pns->unor ?? '') }}</textarea>
</div>

{{-- Instansi Induk --}}
<div>
    <label class="block font-medium">Instansi Induk</label>
    <textarea name="instansi_induk" class="border rounded w-full p-2">{{ old('instansi_induk', $pns->instansi_induk ?? '') }}</textarea>
</div>

{{-- Instansi Kerja --}}
<div>
    <label class="block font-medium">Instansi Kerja</label>
    <textarea name="instansi_kerja" class="border rounded w-full p-2">{{ old('instansi_kerja', $pns->instansi_kerja ?? '') }}</textarea>
</div>

{{-- Satuan Kerja Induk --}}
<div>
    <label class="block font-medium">Satuan Kerja Induk</label>
    <textarea name="satuan_kerja_induk" class="border rounded w-full p-2">{{ old('satuan_kerja_induk', $pns->satuan_kerja_induk ?? '') }}</textarea>
</div>

{{-- Satuan Kerja --}}
<div>
    <label class="block font-medium">Satuan Kerja</label>
    <textarea name="satuan_kerja_kerja" class="border rounded w-full p-2">{{ old('satuan_kerja_kerja', $pns->satuan_kerja_kerja ?? '') }}</textarea>
</div>

{{-- Validasi NIK --}}
<div>
    <label class="block font-medium">Validasi NIK</label>
    <select name="is_valid_nik" class="border rounded w-full p-2">
        <option value="1" {{ old('is_valid_nik', $pns->is_valid_nik ?? 0) == 1 ? 'selected' : '' }}>Ya</option>
        <option value="0" {{ old('is_valid_nik', $pns->is_valid_nik ?? 0) == 0 ? 'selected' : '' }}>Tidak</option>
    </select>
</div>

{{-- Script untuk toggle eselon --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const jenisJabatan = document.getElementById("jenis_jabatan");
        const eselonField = document.getElementById("eselonField");

        function toggleEselon() {
            eselonField.style.display = (jenisJabatan.value === "Struktural") ? "block" : "none";
        }

        toggleEselon();
        jenisJabatan.addEventListener("change", toggleEselon);
    });
</script>
