<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pns;
use App\Models\Pppk;

class DataKategoriController extends Controller
{
    /**
     * Display category index
     */
   public function index()
{
    // Ambil kategori unik dari tabel PNS & PPPK
    $kategoriPns = Pns::select('kategori')->distinct()->pluck('kategori')->toArray();
    $kategoriPppk = Pppk::select('kategori')->distinct()->pluck('kategori')->toArray();

    // Gabungkan kategori unik
    $kategori = array_unique(array_merge($kategoriPns, $kategoriPppk));

    // Hitung jumlah per kategori
    $dataKategori = [];
    foreach ($kategori as $kat) {
        if ($kat != null) {
            $dataKategori[] = [
                'nama' => $kat,
                'total' => Pns::where('kategori', $kat)->count() + Pppk::where('kategori', $kat)->count()
            ];
        }
    }

    // ✨ Urutan kategori yang diinginkan
    $urutan = [
        'Tenaga Kesehatan',
        'Tenaga Medis',
        'Tenaga Kependidikan',
        'Tenaga Pendidik',
        'Manajerial',
        'Teknis',
        'Lainnya',
    ];

    // Urutkan $dataKategori sesuai $urutan di atas
    usort($dataKategori, function ($a, $b) use ($urutan) {
        $posA = array_search($a['nama'], $urutan);
        $posB = array_search($b['nama'], $urutan);

        // Kalau kategori tidak ada di daftar urutan, taruh di paling akhir
        $posA = $posA === false ? count($urutan) : $posA;
        $posB = $posB === false ? count($urutan) : $posB;

        return $posA <=> $posB;
    });

    return view('admin.data.kategori.index', compact('dataKategori'));
}


    /**
     * Show detail category
     */
    public function show($kategori)
    {
        // Ambil pegawai PNS dan PPPK berdasarkan kategori
        $pns = Pns::where('kategori', $kategori)->get();
        $pppk = Pppk::where('kategori', $kategori)->get();

        return view('admin.data.kategori.show', compact('kategori', 'pns', 'pppk'));
    }
}
