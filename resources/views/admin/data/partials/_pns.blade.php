{{-- resources/views/admin/data/partials/_pns.blade.php --}}
<div class="space-y-2">
    <div><strong>NIP:</strong> {{ $data->nip ?? '-' }}</div>
    <div><strong>Nama:</strong> {{ $data->nama ?? '-' }}</div>
    <div><strong>Gelar:</strong> {{ $data->gelar_depan ?? '' }} {{ $data->nama ?? '' }} {{ $data->gelar_belakang ?? '' }}</div>
    <div><strong>Tempat, Tanggal Lahir:</strong> {{ $data->tempat_lahir ?? '-' }}, {{ $data->tanggal_lahir ?? '-' }}</div>
    <div><strong>Jenis Kelamin:</strong> {{ $data->jenis_kelamin ?? '-' }}</div>
    <div><strong>Golongan Darah:</strong> {{ $data->golongan_darah ?? '-' }}</div>
    <div><strong>Agama:</strong> {{ $data->agama ?? '-' }}</div>
    <div><strong>Status Perkawinan:</strong> {{ $data->status_perkawinan ?? '-' }}</div>
    <div><strong>NIK:</strong> {{ $data->nik ?? '-' }}</div>
    <div><strong>Nomor HP:</strong> {{ $data->nomor_hp ?? '-' }}</div>
    <div><strong>Email:</strong> {{ $data->email ?? '-' }}</div>
    <div><strong>Alamat:</strong> {{ $data->alamat ?? '-' }}</div>
    <div><strong>NPWP:</strong> {{ $data->npwp ?? '-' }}</div>

    <hr class="my-2">

    <div><strong>BPJS:</strong> {{ $data->bpjs ?? '-' }}</div>
    <div><strong>Jenis:</strong> {{ $data->jenis ?? '-' }}</div>
    <div><strong>Jenis Pegawai:</strong> {{ $data->jenis_pegawai ?? '-' }}</div>
    <div><strong>Kedudukan Hukum:</strong> {{ $data->kedudukan_hukum_nama ?? '-' }}</div>
    <div><strong>Status CPNS/PNS:</strong> {{ $data->status_cpns_pns ?? '-' }}</div>

    <hr class="my-2">

    <div><strong>Kartu ASN Virtual:</strong> {{ $data->kartu_asn_virtual ?? '-' }}</div>
    <div><strong>Nomor SK CPNS:</strong> {{ $data->nomor_sk_cpns ?? '-' }}</div>
    <div><strong>TMT CPNS:</strong> {{ $data->tmt_cpns ?? '-' }}</div>
    <div><strong>Nomor SK PNS:</strong> {{ $data->nomor_sk_pns ?? '-' }}</div>
    <div><strong>TMT PNS:</strong> {{ $data->tmt_pns ?? '-' }}</div>

    <hr class="my-2">

    <div><strong>Golongan Awal:</strong> {{ $data->gol_awal_nama ?? '-' }}</div>
    <div><strong>Golongan Akhir:</strong> {{ $data->gol_akhir_nama ?? '-' }}</div>
    <div><strong>TMT Golongan:</strong> {{ $data->tmt_golongan ?? '-' }}</div>

    <div><strong>Masa Kerja:</strong> {{ $data->mk_tahun ?? 0 }} Tahun {{ $data->mk_bulan ?? 0 }} Bulan</div>

    <hr class="my-2">

    <div><strong>Jenis Jabatan:</strong> {{ $data->jenis_jabatan ?? '-' }}</div>
    <div><strong>Eselon:</strong> {{ $data->eselon ?? '-' }}</div>
    <div><strong>Jabatan:</strong> {{ $data->jabatan ?? '-' }}</div>
    <div><strong>Kategori:</strong> {{ $data->kategori ?? '-' }}</div>
    <div><strong>Rumpun Jabatan:</strong> {{ $data->rumpun_jabatan ?? '-' }}</div>
    <div><strong>TMT Jabatan:</strong> {{ $data->tmt_jabatan ?? '-' }}</div>

    <div><strong>Riwayat Diklat:</strong> {{ $data->riwayat_diklat ?? '-' }}</div>

    <hr class="my-2">

    <div><strong>Pendidikan:</strong> {{ $data->tingkat_pendidikan_nama ?? '-' }} - {{ $data->pendidikan_nama ?? '-' }} ({{ $data->tahun_lulus ?? '-' }})</div>

    <hr class="my-2">

    <div><strong>UNOR:</strong> {{ $data->unor ?? '-' }}</div>
    <div><strong>Instansi Induk:</strong> {{ $data->instansi_induk ?? '-' }}</div>
    <div><strong>Instansi Kerja:</strong> {{ $data->instansi_kerja ?? '-' }}</div>
    <div><strong>Satuan Kerja Induk:</strong> {{ $data->satuan_kerja_induk ?? '-' }}</div>
    <div><strong>Satuan Kerja Kerja:</strong> {{ $data->satuan_kerja_kerja ?? '-' }}</div>

    <div><strong>Validasi NIK:</strong> {{ $data->is_valid_nik ? 'Valid' : 'Tidak Valid' }}</div>
</div>
