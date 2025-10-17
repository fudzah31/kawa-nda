<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pns;
use App\Models\Pppk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PnsImport;
use App\Imports\PppkImport;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Excel as ExcelFormat;

class AdminController extends Controller
{
    // ================== DASHBOARD ==================
    public function dashboard()
    {
        $pnsCount    = Pns::count();
        $pppkCount   = Pppk::count();
        $totalCount  = $pnsCount + $pppkCount;

        $kategoriPns = Pns::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $kategoriPppk = Pppk::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $kategoriGabungan = [];
        foreach ($kategoriPns as $kategori => $total) {
            $kategoriGabungan[$kategori] = ($kategoriGabungan[$kategori] ?? 0) + $total;
        }
        foreach ($kategoriPppk as $kategori => $total) {
            $kategoriGabungan[$kategori] = ($kategoriGabungan[$kategori] ?? 0) + $total;
        }

        $kategoriUtama = [
            'Tenaga Medis',
            'Tenaga Kesehatan',
            'Tenaga Pendidik',
            'Tenaga Kependidikan',
        ];

        $kategoriCounts = [];
        foreach ($kategoriUtama as $kategori) {
            $kategoriCounts[$kategori] = $kategoriGabungan[$kategori] ?? 0;
        }

        $lainnya = 0;
        foreach ($kategoriGabungan as $kategori => $total) {
            if (!in_array($kategori, $kategoriUtama)) {
                $lainnya += $total;
            }
        }
        $kategoriCounts['Tenaga Lainnya'] = $lainnya;

        return view('admin.dashboard', compact(
            'pnsCount',
            'pppkCount',
            'totalCount',
            'kategoriCounts'
        ));
    }

    // ================== DATA PEGAWAI ==================
    public function dataIndex()
    {
        return view('admin.data.index');
    }

    public function dataList(Request $request)
    {
        try {
            $pns = Pns::select(
                'id',
                'nama',
                'nip',
                'jabatan',
                DB::raw("'PNS' as jenis")
            );

            $pppk = Pppk::select(
                'id',
                'nama',
                'nip',
                'jabatan',
                DB::raw("'PPPK' as jenis")
            );

            $data = $pns->unionAll($pppk)->get();

            // filter jenis pegawai
            if ($request->filled('jenis')) {
                $data = $data->where('jenis', strtoupper($request->jenis))->values();
            }

            // filter pencarian
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                $data = $data->filter(function ($item) use ($search) {
                    return str_contains(strtolower($item->nama), $search)
                        || str_contains(strtolower($item->nip), $search)
                        || str_contains(strtolower($item->jabatan), $search);
                })->values();
            }

            return response()->json(['data' => $data]);

        } catch (\Throwable $e) {
            Log::error("Gagal memuat data pegawai", [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan saat memuat data pegawai.'
            ], 500);
        }
    }

    // ================== CREATE ==================
    public function dataCreate()
    {
        return view('admin.data.create');
    }

    public function dataStore(Request $request)
    {
        $jenis = strtolower($request->input('jenis', ''));

        if (!in_array($jenis, ['pns', 'pppk'])) {
            return back()->withErrors('Jenis pegawai tidak valid. Pilih PNS atau PPPK.');
        }

        $input = $request->except(['_token']);

        try {
            if ($jenis === 'pns') {
                $pegawai = Pns::create($input);
            } else {
                $pegawai = Pppk::create($input);
            }

            return redirect()->route('admin.data.index')
                ->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $e) {
            Log::error("Gagal menyimpan data pegawai", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // ================== UPLOAD FILE ==================
    public function dataUpload(Request $request)
    {
        $jenis = strtolower($request->input('jenis', ''));

        if (!in_array($jenis, ['pns', 'pppk'])) {
            return back()->withErrors('Jenis pegawai tidak valid untuk upload.');
        }

        if (!$request->hasFile('file')) {
            return back()->withErrors('Tidak ada file yang diupload.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->withErrors('File upload tidak valid.');
        }

        try {
            if ($jenis === 'pns') {
                Excel::import(new PnsImport, $file);
            } else {
                Excel::import(new PppkImport, $file);
            }

            return redirect()->route('admin.data.index')
                ->with('success', "File {$jenis} berhasil diupload & disimpan.");
        } catch (\Throwable $e) {
            return back()->withErrors('Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }

    // ================== SHOW DETAIL ==================
    public function dataShow($jenis, $id)
    {
        $jenisUpper = strtoupper($jenis);

        if ($jenisUpper === 'PNS') {
            $pegawai = Pns::findOrFail($id);
        } elseif ($jenisUpper === 'PPPK') {
            $pegawai = Pppk::findOrFail($id);
        } else {
            abort(404, 'Jenis pegawai tidak ditemukan.');
        }

        return view('admin.data.show', [
            'pegawai' => $pegawai,
            'jenis'   => strtolower($jenis),
            'data'    => $pegawai,
        ]);
    }

    // ================== EDIT ==================
    public function dataEdit($jenis, $id)
    {
        $jenisLower = strtolower($jenis);
        $jenisUpper = strtoupper($jenisLower);

        if ($jenisUpper === 'PNS') {
            $pns = Pns::findOrFail($id);
            $view = 'admin.data.partials._edit-pns';

            return view('admin.data.edit', [
                'pns'     => $pns,
                'jenis'   => $jenisLower,
                'partial' => $view
            ]);
        } elseif ($jenisUpper === 'PPPK') {
            $pppk = Pppk::findOrFail($id);
            $view = 'admin.data.partials._edit-pppk';

            return view('admin.data.edit', [
                'pppk'    => $pppk,
                'jenis'   => $jenisLower,
                'partial' => $view
            ]);
        } else {
            abort(404, 'Jenis pegawai tidak ditemukan.');
        }
    }

    // ================== UPDATE ==================
    public function dataUpdate(Request $request, $jenis, $id)
    {
        $jenisLower = strtolower($jenis);
        $jenisUpper = strtoupper($jenisLower);

        if ($jenisUpper === 'PNS') {
            $pegawai = Pns::findOrFail($id);
        } elseif ($jenisUpper === 'PPPK') {
            $pegawai = Pppk::findOrFail($id);
        } else {
            abort(404);
        }

        try {
            $pegawai->update($request->except(['_token', '_method']));
        } catch (\Throwable $e) {
            Log::error("Gagal update data $jenisUpper", [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);

            $pegawai->nama    = $request->input('nama', $pegawai->nama);
            $pegawai->nip     = $request->input('nip', $pegawai->nip);
            $pegawai->jabatan = $request->input('jabatan', $pegawai->jabatan);
            $pegawai->save();
        }

        return redirect()->route('admin.data.show', [$jenisLower, $pegawai->id])
                         ->with('success', "$jenisUpper berhasil diperbarui.");
    }

    // ================== DESTROY ==================
    public function dataDestroy($jenis, $id)
    {
        try {
            $jenisUpper = strtoupper($jenis);

            if ($jenisUpper === 'PNS') {
                $deleted = Pns::destroy($id);
            } elseif ($jenisUpper === 'PPPK') {
                $deleted = Pppk::destroy($id);
            } else {
                abort(404);
            }

            // Jika request dari AJAX, balas JSON agar bisa reload DataTable
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "$jenisUpper berhasil dihapus."
                ]);
            }

            return redirect()->route('admin.data.index')
                ->with('success', "$jenisUpper berhasil dihapus.");
        } catch (\Throwable $e) {
            Log::error("Gagal menghapus data pegawai", [
                'jenis' => $jenis ?? '-',
                'id' => $id ?? '-',
                'message' => $e->getMessage(),
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data.'
                ], 500);
            }

            return redirect()->route('admin.data.index')
                ->withErrors('Gagal menghapus data.');
        }
    }

    // ================== PROFILE ADMIN ==================
    public function profileIndex()
    {
        $admin = auth()->user();
        return view('admin.profile.index', compact('admin'));
    }

    // ================== LAPORAN ==================
    public function laporanIndex(Request $request)
    {
        $pns = Pns::select(
            'nip','nama','gelar_depan','gelar_belakang','tempat_lahir','tanggal_lahir',
            'jenis_kelamin','golongan_darah','agama','status_perkawinan','nik','nomor_hp',
            'email','alamat','npwp','bpjs','jenis','jenis_pegawai',
            'kedudukan_hukum_nama as kedudukan_hukum','status_cpns_pns',
            'kartu_asn_virtual','nomor_sk_cpns','tmt_cpns','nomor_sk_pns','tmt_pns',
            'gol_awal_nama as gol_awal','gol_akhir_nama as gol_akhir','tmt_golongan',
            'mk_tahun','mk_bulan','jenis_jabatan','eselon','jabatan','kategori','rumpun_jabatan',
            'tmt_jabatan','riwayat_diklat as riwayat_pelatihan','tingkat_pendidikan_nama as tingkat_pendidikan',
            'pendidikan_nama as pendidikan','tahun_lulus','unor','instansi_induk','instansi_kerja',
            'satuan_kerja_induk','satuan_kerja_kerja','is_valid_nik',
            DB::raw("'PNS' as jenis_data")
        );

        $pppk = Pppk::select(
            'nip','nama','gelar_depan','gelar_belakang','tempat_lahir','tanggal_lahir',
            'jenis_kelamin','golongan_darah','agama','status_perkawinan','nik','nomor_hp',
            'email','alamat','npwp_nomor as npwp','bpjs','jenis','jenis_pegawai','kedudukan_hukum',
            'status_cpns_pns','kartu_asn_virtual','nomor_sk_cpns','tmt_cpns',
            DB::raw("NULL as nomor_sk_pns"),DB::raw("NULL as tmt_pns"),
            'gol_awal','gol_akhir','tmt_golongan','mk_tahun','mk_bulan','jenis_jabatan',
            DB::raw("NULL as eselon"),'jabatan','kategori','rumpun_jabatan','tmt_jabatan',
            'riwayat_pelatihan','tingkat_pendidikan','pendidikan','tahun_lulus','unor',
            'instansi_induk','instansi_kerja','satuan_kerja_induk','satuan_kerja_kerja',
            'is_valid_nik',DB::raw("'PPPK' as jenis_data")
        );

        $query = $pns->toBase()->unionAll($pppk->toBase());
        $pegawai = DB::table(DB::raw("({$query->toSql()}) as pegawai"))
            ->mergeBindings($query);

        if ($request->filled('jenis')) {
            $pegawai->where('jenis_data', $request->jenis);
        }

        $pegawai = $pegawai->get();

        return view('admin.laporan.index', compact('pegawai'));
    }

    // ================== EXPORT LAPORAN ==================
    public function laporanExport($format, Request $request)
    {
        $jenis = $request->query('jenis');
        $fileName = 'laporan_pegawai_' . strtolower($jenis ?? 'semua');

        if ($format === 'excel') {
            return Excel::download(new PegawaiExport($jenis), $fileName . '.xlsx');
        }

        if ($format === 'csv') {
            return Excel::download(new PegawaiExport($jenis), $fileName . '.csv', ExcelFormat::CSV);
        }

        return back()->with('error', 'Format tidak dikenali.');
    }

    // ================== DATA UNOR ==================
public function dataUnor()
{
    // Ambil data UNOR dari tabel PNS dan PPPK
    $unorPns = \App\Models\Pns::select('unor')->whereNotNull('unor');
    $unorPppk = \App\Models\Pppk::select('unor')->whereNotNull('unor');

    // Gabungkan dua query lalu ambil hasil unik
    $unorList = $unorPns
        ->union($unorPppk)
        ->pluck('unor')
        ->filter()        // buang null / kosong
        ->unique()
        ->sort()
        ->values();

    return view('admin.data.unor.index', compact('unorList'));
}

// ================== DETAIL UNOR ==================
public function showUnor($namaUnor)
{


    // Ambil semua pegawai (PNS & PPPK) berdasarkan UNOR
    $pns = \App\Models\Pns::where('unor', $namaUnor)
        ->select('id', 'nama', 'nip', 'jabatan', DB::raw("'PNS' as jenis"))
        ->get();

    $pppk = \App\Models\Pppk::where('unor', $namaUnor)
        ->select('id', 'nama', 'nip', 'jabatan', DB::raw("'PPPK' as jenis"))
        ->get();

    // Gabungkan hasil keduanya
    $pegawai = $pns->concat($pppk);

    // Urutkan hasil gabungan berdasarkan nama (opsional)
    $pegawai = $pegawai->sortBy('nama')->values();

    return view('admin.data.unor.show', compact('namaUnor', 'pegawai'));
}

 // ================== DATA KATEGORI ==================
    public function dataKategori()
    {
        $kategoriPns = Pns::select('kategori')->distinct()->pluck('kategori')->filter();
        $kategoriPppk = Pppk::select('kategori')->distinct()->pluck('kategori')->filter();
        $kategoriList = $kategoriPns->merge($kategoriPppk)->unique()->sort()->values();

        return view('admin.data.kategori.index', compact('kategoriList'));
    }

    public function showKategori($namaKategori)
    {
        $pns = Pns::where('kategori', $namaKategori)->select('id','nama','nip','jabatan',DB::raw("'PNS' as jenis"))->get();
        $pppk = Pppk::where('kategori', $namaKategori)->select('id','nama','nip','jabatan',DB::raw("'PPPK' as jenis"))->get();
        $pegawai = $pns->concat($pppk)->sortBy('nama')->values();
        return view('admin.data.kategori.show', compact('namaKategori', 'pegawai'));
    }
}


