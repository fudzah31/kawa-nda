<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Pns;
use App\Models\Pppk;
use Illuminate\Http\Request;

class DataUnorController extends Controller
{
    // =========================
    // Halaman daftar UNOR
    // =========================
    public function index()
    {
        $unorList = collect()
            ->merge(Pns::pluck('unor'))
            ->merge(Pppk::pluck('unor'))
            ->filter() // hilangkan null/kosong
            ->unique() // hanya ambil yang unik
            ->values()
            ->map(function ($unor) {
                return [
                    'nama' => $unor,
                    'slug' => Str::slug($unor), // contoh: "Dinas Pendidikan" -> "dinas-pendidikan"
                ];
            });

        return view('admin.data.unor.index', compact('unorList'));
    }

    // =========================
    // Halaman detail UNOR → daftar pegawai
    // =========================
    public function show($slug)
{
    $decodedNama = Str::of(urldecode($slug))
        ->replace(['-', '_'], ' ')
        ->replace('%20', ' ')
        ->lower()
        ->trim();

    // normalisasi fungsi untuk pencarian
    $normalize = fn($q) => "
        REPLACE(
            REPLACE(
                REPLACE(
                    REPLACE(LOWER(TRIM($q)), '-', ''),
                ' ', ''),
            '.', ''),
        ',', '')
    ";

    $pns = Pns::whereRaw("{$normalize('unor')} LIKE ?", ['%' . str_replace(['-', ' ', '.', ','], '', $decodedNama) . '%'])->get();

    $pppk = Pppk::whereRaw("{$normalize('unor')} LIKE ?", ['%' . str_replace(['-', ' ', '.', ','], '', $decodedNama) . '%'])->get();

    if ($pns->isEmpty() && $pppk->isEmpty()) {
        return redirect()
            ->route('admin.data.unor.index')
            ->with('error', 'Tidak ada pegawai di UNOR ini.');
    }

    $namaUnor = $pns->first()->unor ?? $pppk->first()->unor ?? Str::upper($decodedNama);

    return view('admin.data.unor.show', compact('namaUnor', 'pns', 'pppk'));
}

}
