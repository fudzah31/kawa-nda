<?php

namespace App\Exports;

use App\Models\Pns;
use App\Models\Pppk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PegawaiExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $jenis;

    public function __construct($jenis = null)
    {
        $this->jenis = $jenis;
    }

    public function collection()
    {
        // === PNS ===
        $pnsQuery = Pns::select(
            'nip',
            'nama',
            'gelar_depan',
            'gelar_belakang',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_perkawinan',
            'nik',
            'nomor_hp',
            'email',
            'alamat',
            'npwp',
            'bpjs',
            'jenis',
            'jenis_pegawai',
            DB::raw("NULL as kedudukan_hukum"),
            'status_cpns_pns',
            'kartu_asn_virtual',
            'nomor_sk_cpns',
            'tmt_cpns',
            'nomor_sk_pns',
            'tmt_pns',
            DB::raw("gol_awal_nama as gol_awal"),
            DB::raw("gol_akhir_nama as gol_akhir"),
            'tmt_golongan',
            'mk_tahun',
            'mk_bulan',
            'jenis_jabatan',
            'eselon',
            'jabatan',
            'kategori',
            'rumpun_jabatan',
            'tmt_jabatan',
            DB::raw("riwayat_diklat as riwayat_pelatihan"),
            DB::raw("tingkat_pendidikan_nama as tingkat_pendidikan"),
            DB::raw("pendidikan_nama as pendidikan"),
            'tahun_lulus',
            'unor',
            'instansi_induk',
            'instansi_kerja',
            'satuan_kerja_induk',
            'satuan_kerja_kerja',
            'is_valid_nik',
            DB::raw("'PNS' as jenis_data")
        );

        // === PPPK ===
        $pppkQuery = Pppk::select(
            'nip',
            'nama',
            'gelar_depan',
            'gelar_belakang',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_perkawinan',
            'nik',
            'nomor_hp',
            'email',
            'alamat',
            DB::raw("npwp_nomor as npwp"),
            'bpjs',
            'jenis',
            'jenis_pegawai',
            'kedudukan_hukum',
            'status_cpns_pns',
            'kartu_asn_virtual',
            'nomor_sk_cpns',
            'tmt_cpns',
            DB::raw("NULL as nomor_sk_pns"),
            DB::raw("NULL as tmt_pns"),
            'gol_awal',
            'gol_akhir',
            'tmt_golongan',
            'mk_tahun',
            'mk_bulan',
            'jenis_jabatan',
            DB::raw("NULL as eselon"),
            'jabatan',
            'kategori',
            'rumpun_jabatan',
            'tmt_jabatan',
            'riwayat_pelatihan',
            'tingkat_pendidikan',
            'pendidikan',
            'tahun_lulus',
            'unor',
            'instansi_induk',
            'instansi_kerja',
            'satuan_kerja_induk',
            'satuan_kerja_kerja',
            'is_valid_nik',
            DB::raw("'PPPK' as jenis_data")
        );

        // === Filter berdasarkan pilihan ===
        if ($this->jenis === 'PNS') {
            return $pnsQuery->get();
        } elseif ($this->jenis === 'PPPK') {
            return $pppkQuery->get();
        }

        return $pnsQuery->unionAll($pppkQuery)->get();
    }

    // ✅ Mapping agar NIP & NIK tidak jadi notasi ilmiah
    public function map($row): array
    {
        return [
            (string) $row->nip, // 👉 paksa string
            $row->nama,
            $row->gelar_depan,
            $row->gelar_belakang,
            $row->tempat_lahir,
            $row->tanggal_lahir,
            $row->jenis_kelamin,
            $row->golongan_darah,
            $row->agama,
            $row->status_perkawinan,
            (string) $row->nik, // 👉 paksa string
            $row->nomor_hp,
            $row->email,
            $row->alamat,
            $row->npwp,
            $row->bpjs,
            $row->jenis,
            $row->jenis_pegawai,
            $row->kedudukan_hukum,
            $row->status_cpns_pns,
            $row->kartu_asn_virtual,
            $row->nomor_sk_cpns,
            $row->tmt_cpns,
            $row->nomor_sk_pns,
            $row->tmt_pns,
            $row->gol_awal,
            $row->gol_akhir,
            $row->tmt_golongan,
            $row->mk_tahun,
            $row->mk_bulan,
            $row->jenis_jabatan,
            $row->eselon,
            $row->jabatan,
            $row->kategori,
            $row->rumpun_jabatan,
            $row->tmt_jabatan,
            $row->riwayat_pelatihan,
            $row->tingkat_pendidikan,
            $row->pendidikan,
            $row->tahun_lulus,
            $row->unor,
            $row->instansi_induk,
            $row->instansi_kerja,
            $row->satuan_kerja_induk,
            $row->satuan_kerja_kerja,
            $row->is_valid_nik,
            $row->jenis_data,
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'nama',
            'gelar_depan',
            'gelar_belakang',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_perkawinan',
            'nik',
            'nomor_hp',
            'email',
            'alamat',
            'npwp',
            'bpjs',
            'jenis',
            'jenis_pegawai',
            'kedudukan_hukum',
            'status_cpns_pns',
            'kartu_asn_virtual',
            'nomor_sk_cpns',
            'tmt_cpns',
            'nomor_sk_pns',
            'tmt_pns',
            'gol_awal',
            'gol_akhir',
            'tmt_golongan',
            'mk_tahun',
            'mk_bulan',
            'jenis_jabatan',
            'eselon',
            'jabatan',
            'kategori',
            'rumpun_jabatan',
            'tmt_jabatan',
            'riwayat_pelatihan',
            'tingkat_pendidikan',
            'pendidikan',
            'tahun_lulus',
            'unor',
            'instansi_induk',
            'instansi_kerja',
            'satuan_kerja_induk',
            'satuan_kerja_kerja',
            'is_valid_nik',
            'jenis_data',
        ];
    }

    // ✅ Format kolom NIP (A) & NIK (K) jadi teks
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // NIP
            'K' => NumberFormat::FORMAT_TEXT, // NIK
        ];
    }
}
