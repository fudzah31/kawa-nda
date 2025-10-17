{{-- resources/views/admin/data/partials/form-fields-pppk.blade.php --}}

{{-- Identitas Dasar --}}
<div>
  <label class="block font-medium">NIP</label>
  <input type="text" name="nip" class="border p-2 rounded w-full" placeholder="Masukkan NIP" required>
</div>

<div>
  <label class="block font-medium">Nama Lengkap</label>
  <input type="text" name="nama" class="border p-2 rounded w-full" required>
</div>

<div>
  <label class="block font-medium">Gelar Depan</label>
  <input type="text" name="gelar_depan" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Gelar Belakang</label>
  <input type="text" name="gelar_belakang" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Tempat Lahir</label>
  <input type="text" name="tempat_lahir" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Tanggal Lahir</label>
  <input type="date" name="tanggal_lahir" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Jenis Kelamin</label>
  <select name="jenis_kelamin" class="border p-2 rounded w-full">
    <option value="">-- Pilih --</option>
    <option value="M">Laki-laki</option>
    <option value="F">Perempuan</option>
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
  </select>
</div>

<div>
  <label class="block font-medium">Golongan Darah</label>
  <input type="text" name="golongan_darah" class="border p-2 rounded w-full" placeholder="A / B / O / AB">
</div>

<div>
  <label class="block font-medium">Agama</label>
  <select name="agama" class="border p-2 rounded w-full">
    <option value="">-- Pilih --</option>
    <option value="Islam">Islam</option>
    <option value="Kristen">Kristen</option>
    <option value="Katolik">Katolik</option>
    <option value="Hindu">Hindu</option>
    <option value="Buddha">Buddha</option>
    <option value="Konghucu">Konghucu</option>
  </select>
</div>

<div>
  <label class="block font-medium">Status Perkawinan</label>
  <input type="text" name="status_perkawinan" class="border p-2 rounded w-full" placeholder="Kawin / Belum Kawin / Cerai">
</div>

<div>
  <label class="block font-medium">NIK</label>
  <input type="text" name="nik" class="border p-2 rounded w-full" required>
</div>

<div>
  <label class="block font-medium">Nomor HP</label>
  <input type="text" name="nomor_hp" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Email</label>
  <input type="email" name="email" class="border p-2 rounded w-full">
</div>

<div class="md:col-span-2">
  <label class="block font-medium">Alamat</label>
  <textarea name="alamat" class="border p-2 rounded w-full" rows="2"></textarea>
</div>

<div>
  <label class="block font-medium">NPWP</label>
  <input type="text" name="npwp_nomor" class="border p-2 rounded w-full">
</div>

{{-- Kepegawaian Dasar --}}
<div>
  <label class="block font-medium">BPJS</label>
  <input type="text" name="bpjs" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Jenis</label>
  <input type="text" name="jenis" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Jenis Pegawai</label>
  <select name="jenis_pegawai" class="border p-2 rounded w-full">
    <option value="PPPK" selected>PPPK</option>
    <option value="PNS">PNS</option>
    <option value="Lainnya">Lainnya</option>
  </select>
</div>

<div>
  <label class="block font-medium">Kedudukan Hukum</label>
  <input type="text" name="kedudukan_hukum" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Status CPNS/PNS</label>
  <select name="status_cpns_pns" class="border p-2 rounded w-full">
    <option value="">-- Pilih --</option>
    <option value="CPNS">CPNS</option>
    <option value="PNS">PNS</option>
    <option value="PPPK">PPPK</option>
    <option value="Lainnya">Lainnya</option>
  </select>
</div>

{{-- SK & CPNS --}}
<div>
  <label class="block font-medium">Kartu ASN Virtual</label>
  <input type="text" name="kartu_asn_virtual" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Nomor SK CPNS</label>
  <input type="text" name="nomor_sk_cpns" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">TMT CPNS</label>
  <input type="date" name="tmt_cpns" class="border p-2 rounded w-full">
</div>

{{-- Golongan --}}
<div>
  <label class="block font-medium">Golongan Awal</label>
  <input type="text" name="gol_awal" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Golongan Akhir</label>
  <input type="text" name="gol_akhir" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">TMT Golongan</label>
  <input type="date" name="tmt_golongan" class="border p-2 rounded w-full">
</div>

{{-- Masa Kerja --}}
<div>
  <label class="block font-medium">Masa Kerja (Tahun)</label>
  <input type="number" name="mk_tahun" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Masa Kerja (Bulan)</label>
  <input type="number" name="mk_bulan" class="border p-2 rounded w-full">
</div>

{{-- Jabatan --}}
<div>
  <label class="block font-medium">Jenis Jabatan</label>
  <select name="jenis_jabatan" class="border p-2 rounded w-full">
    <option value="">-- Pilih --</option>
    <option value="Fungsional">Fungsional</option>
    <option value="Struktural">Struktural</option>
    <option value="Pelaksana">Pelaksana</option>
  </select>
</div>

<div>
  <label class="block font-medium">Jabatan</label>
  <input type="text" name="jabatan" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Kategori</label>
  <input type="text" name="kategori" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Rumpun Jabatan</label>
  <input type="text" name="rumpun_jabatan" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">TMT Jabatan</label>
  <input type="date" name="tmt_jabatan" class="border p-2 rounded w-full">
</div>

{{-- Pelatihan --}}
<div class="md:col-span-2">
  <label class="block font-medium">Riwayat Pelatihan</label>
  <textarea name="riwayat_pelatihan" class="border p-2 rounded w-full" rows="2"></textarea>
</div>

{{-- Pendidikan --}}
<div>
  <label class="block font-medium">Tingkat Pendidikan</label>
  <input type="text" name="tingkat_pendidikan" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Pendidikan</label>
  <input type="text" name="pendidikan" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Tahun Lulus</label>
  <input type="number" name="tahun_lulus" class="border p-2 rounded w-full" min="1900" max="2099">
</div>

{{-- Unit Organisasi & Instansi --}}
<div>
  <label class="block font-medium">UNOR</label>
  <input type="text" name="unor" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Instansi Induk</label>
  <input type="text" name="instansi_induk" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Instansi Kerja</label>
  <input type="text" name="instansi_kerja" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Satuan Kerja Induk</label>
  <input type="text" name="satuan_kerja_induk" class="border p-2 rounded w-full">
</div>

<div>
  <label class="block font-medium">Satuan Kerja Kerja</label>
  <input type="text" name="satuan_kerja_kerja" class="border p-2 rounded w-full">
</div>

{{-- Validasi NIK --}}
<div>
  <label class="inline-flex items-center">
    <input type="checkbox" name="is_valid_nik" value="1" class="mr-2">
    Validasi NIK
  </label>
</div>
