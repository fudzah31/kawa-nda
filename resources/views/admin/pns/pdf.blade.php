<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data PNS</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Data PNS</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Gelar Depan</th>
                <th>Gelar Belakang</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Golongan Darah</th>
                <th>Agama</th>
                <th>Status Perkawinan</th>
                <th>NIK</th>
                <th>Nomor HP</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>NPWP</th>
                <th>BPJS</th>
                <th>Jenis Pegawai</th>
                <th>Kedudukan Hukum</th>
                <th>Status CPNS/PNS</th>
                <th>Kartu ASN Virtual</th>
                <th>Nomor SK CPNS</th>
                <th>TMT CPNS</th>
                <th>Nomor SK PNS</th>
                <th>TMT PNS</th>
                <th>Golongan Awal</th>
                <th>Golongan Akhir</th>
                <th>TMT Golongan</th>
                <th>Masa Kerja (Tahun/Bulan)</th>
                <th>Jenis Jabatan</th>
                <th>Jabatan</th>
                <th>Eselon</th>
                <th>TMT Jabatan</th>
                <th>Riwayat Diklat</th>
                <th>Tingkat Pendidikan</th>
                <th>Pendidikan</th>
                <th>Tahun Lulus</th>
                <th>Unit Organisasi</th>
                <th>Instansi Induk</th>
                <th>Instansi Kerja</th>
                <th>Satuan Kerja Induk</th>
                <th>Satuan Kerja</th>
                <th>Validasi NIK</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPegawai as $pns)
            <tr>
                <td>{{ $pns->id }}</td>
                <td>{{ $pns->nip }}</td>
                <td>{{ $pns->nama }}</td>
                <td>{{ $pns->gelar_depan }}</td>
                <td>{{ $pns->gelar_belakang }}</td>
                <td>{{ $pns->tempat_lahir }}</td>
                <td>{{ $pns->tanggal_lahir }}</td>
                <td>{{ $pns->jenis_kelamin }}</td>
                <td>{{ $pns->golongan_darah }}</td>
                <td>{{ $pns->agama }}</td>
                <td>{{ $pns->status_perkawinan }}</td>
                <td>{{ $pns->nik }}</td>
                <td>{{ $pns->nomor_hp }}</td>
                <td>{{ $pns->email }}</td>
                <td>{{ $pns->alamat }}</td>
                <td>{{ $pns->npwp }}</td>
                <td>{{ $pns->bpjs }}</td>
                <td>{{ $pns->jenis_pegawai }}</td>
                <td>{{ $pns->kedudukan_hukum }}</td>
                <td>{{ $pns->status_cpns_pns }}</td>
                <td>{{ $pns->kartu_asn_virtual }}</td>
                <td>{{ $pns->nomor_sk_cpns }}</td>
                <td>{{ $pns->tmt_cpns }}</td>
                <td>{{ $pns->nomor_sk_pns }}</td>
                <td>{{ $pns->tmt_pns }}</td>
                <td>{{ $pns->golongan_awal }}</td>
                <td>{{ $pns->golongan_akhir }}</td>
                <td>{{ $pns->tmt_golongan }}</td>
                <td>{{ $pns->masa_kerja_tahun }}/{{ $pns->masa_kerja_bulan }}</td>
                <td>{{ $pns->jenis_jabatan }}</td>
                <td>{{ $pns->jabatan }}</td>
                <td>{{ $pns->eselon }}</td>
                <td>{{ $pns->tmt_jabatan }}</td>
                <td>{{ $pns->riwayat_diklat }}</td>
                <td>{{ $pns->tingkat_pendidikan }}</td>
                <td>{{ $pns->pendidikan }}</td>
                <td>{{ $pns->tahun_lulus }}</td>
                <td>{{ $pns->unit_organisasi }}</td>
                <td>{{ $pns->instansi_induk }}</td>
                <td>{{ $pns->instansi_kerja }}</td>
                <td>{{ $pns->satuan_kerja_induk }}</td>
                <td>{{ $pns->satuan_kerja }}</td>
                <td>{{ $pns->validasi_nik ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $pns->created_at }}</td>
                <td>{{ $pns->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
