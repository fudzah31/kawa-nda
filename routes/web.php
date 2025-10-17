<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLayananController;
use App\Http\Controllers\DataUnorController;
use App\Http\Controllers\DataKategoriController;

/*
|--------------------------------------------------------------------------
| ROOT REDIRECT
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/auth/login');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    // ✅ Login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');

    // ✅ Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // ✅ Logout
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // ✅ Forgot Password + OTP
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.sendOtp');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verifyOtp');
    Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resendOtp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| PUBLIC AJAX ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/get-nama/{username}', [AuthController::class, 'getNama'])->name('get.nama');

// ✅ Ambil data PNS berdasarkan NIP
Route::get('/get-pns/{nip}', function ($nip) {
    $pns = \App\Models\Pns::where('nip', $nip)->first();
    if ($pns) {
        return response()->json([
            'nama' => $pns->nama,
            'email' => $pns->email,
        ]);
    }
    return response()->json([]);
})->name('get.pns');

// ✅ Gabungan PNS & PPPK berdasarkan NIP
Route::get('/get-pegawai/{nip}', [AuthController::class, 'getPegawai'])->name('get.pegawai');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ✅ Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | ADMIN PROFILE
        |--------------------------------------------------------------------------
        */
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminController::class, 'profileIndex'])->name('index');
            Route::post('/update', [AdminController::class, 'profileUpdate'])->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN DATA (PEGAWAI, UNOR, JABATAN, KATEGORI)
        |--------------------------------------------------------------------------
        */
        Route::prefix('data')->name('data.')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | ADMIN DATA UNOR
            |--------------------------------------------------------------------------
            */
            Route::prefix('unor')->name('unor.')->group(function () {
                Route::get('/', [DataUnorController::class, 'index'])->name('index');
                Route::get('/{slug}', [DataUnorController::class, 'show'])->name('show');
            });

            /*
            |--------------------------------------------------------------------------
            | ✅ ADMIN DATA KATEGORI (DIBENARKAN)
            |--------------------------------------------------------------------------
            */
            Route::prefix('kategori')->name('kategori.')->group(function () {
                Route::get('/', [DataKategoriController::class, 'index'])->name('index'); // /admin/data/kategori
                Route::get('/{kategori}', [DataKategoriController::class, 'show'])->name('show'); // /admin/data/kategori/{kategori}
            });

            /*
            |--------------------------------------------------------------------------
            | ADMIN DATA PEGAWAI
            |--------------------------------------------------------------------------
            */
            Route::get('/', [AdminController::class, 'dataIndex'])->name('index');
            Route::get('/list', [AdminController::class, 'dataList'])->name('list');
            Route::get('/create', [AdminController::class, 'dataCreate'])->name('create');
            Route::post('/store', [AdminController::class, 'dataStore'])->name('store');
            Route::post('/upload', [AdminController::class, 'dataUpload'])->name('upload');

            // ✅ Batasi agar tidak bentrok
            Route::get('/{jenis}/{id}', [AdminController::class, 'dataShow'])
                ->whereNumber('id')
                ->name('show');
            Route::get('/{jenis}/{id}/edit', [AdminController::class, 'dataEdit'])
                ->whereNumber('id')
                ->name('edit');
            Route::put('/{jenis}/{id}', [AdminController::class, 'dataUpdate'])
                ->whereNumber('id')
                ->name('update');
            Route::delete('/{jenis}/{id}', [AdminController::class, 'dataDestroy'])
                ->whereNumber('id')
                ->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN PESAN
        |--------------------------------------------------------------------------
        */
        Route::prefix('pesan')->name('pesan.')->group(function () {
            Route::get('/', [PesanController::class, 'index'])->name('index');
            Route::get('/{id}', [PesanController::class, 'show'])->name('show');
            Route::post('/', [PesanController::class, 'store'])->name('store');
            Route::put('/{id}', [PesanController::class, 'update'])->name('update');
            Route::put('/{id}/kembali', [PesanController::class, 'kembali'])->name('kembali');
            Route::delete('/{id}', [PesanController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN LAPORAN
        |--------------------------------------------------------------------------
        */
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [AdminController::class, 'laporanIndex'])->name('index');
            Route::get('/cetak', [AdminController::class, 'laporanCetak'])->name('cetak');
            Route::get('/detail/{id}', [AdminController::class, 'laporanDetail'])->name('detail');
            Route::get('/export/{format}', [AdminController::class, 'laporanExport'])->name('export');
        });
    });

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // ✅ Dashboard
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | USER PROFILE
        |--------------------------------------------------------------------------
        */
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserController::class, 'profileIndex'])->name('index');
            Route::post('/update', [UserController::class, 'profileUpdate'])->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | USER PESAN
        |--------------------------------------------------------------------------
        */
        Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');

        /*
        |--------------------------------------------------------------------------
        | LAYANAN USER
        |--------------------------------------------------------------------------
        */
        Route::prefix('layanan')->name('layanan.')->group(function () {
            Route::get('/', [UserLayananController::class, 'index'])->name('index');

            // ✅ Kenaikan Pangkat
            Route::get('/kenaikan-pangkat', [UserLayananController::class, 'kenaikanPangkat'])->name('kenaikan-pangkat');
            Route::post('/kenaikan-pangkat', [UserLayananController::class, 'storeKenaikanPangkat'])->name('kenaikan-pangkat.store');

            // ✅ Mutasi UNOR
            Route::get('/mutasi-unor', [UserLayananController::class, 'mutasiUnor'])->name('mutasi-unor');
            Route::post('/mutasi-unor', [UserLayananController::class, 'storeMutasiUnor'])->name('mutasi-unor.store');

            // ✅ Mutasi Jabatan
            Route::get('/mutasi-jabatan', [UserLayananController::class, 'mutasiJabatan'])->name('mutasi-jabatan');
            Route::post('/mutasi-jabatan', [UserLayananController::class, 'storeMutasiJabatan'])->name('mutasi-jabatan.store');

            // ✅ Update Profil
            Route::get('/update-profil', [UserLayananController::class, 'updateProfil'])->name('update-profil');
            Route::post('/update-profil', [UserLayananController::class, 'storeUpdateProfil'])->name('update-profil.store');

            // ✅ Hapus Banyak & Satu
            Route::delete('/bulk-delete', [UserLayananController::class, 'destroyMultiple'])->name('bulkDelete');
            Route::delete('/{id}', [UserLayananController::class, 'destroy'])->name('destroy');
        });
    });
