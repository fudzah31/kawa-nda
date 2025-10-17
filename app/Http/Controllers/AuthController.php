<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pns;
use App\Models\Pppk;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('username');
        $password = $request->input('password');

        Log::info('Login attempt', [
            'input' => $loginInput,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString()
        ]);

        $user = User::where('username', $loginInput)
                    ->orWhere('email', $loginInput)
                    ->first();

        if (!$user) {
            Log::warning('Login failed - user not found', ['input' => $loginInput]);
            Alert::error('Login Gagal', 'Username atau Email tidak ditemukan.');
            return back()->withInput()->withErrors(['username' => 'Username atau Email tidak ditemukan.']);
        }

        if (!Hash::check($password, $user->password)) {
            Log::warning('Login failed - wrong password', [
                'user_id' => $user->id ?? null,
                'input' => $loginInput
            ]);
            Alert::error('Login Gagal', 'Password salah.');
            return back()->withInput()->withErrors(['password' => 'Password salah.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        Log::info('Login success', ['user_id' => $user->id, 'role' => $user->role]);

        if ($user->role === 'admin') {
            Alert::success('Login Berhasil', 'Selamat datang Admin ' . $user->name);
            return redirect()->route('admin.dashboard');
        }

        Alert::success('Login Berhasil', 'Selamat datang ' . $user->name);
        return redirect()->route('user.dashboard');
    }

    /**
     * Ambil nama berdasarkan username/email (dipakai AJAX)
     */
    public function getNama($username)
    {
        $user = User::where('username', $username)
                    ->orWhere('email', $username)
                    ->first();

        if ($user) {
            return response()->json(['nama' => $user->name]);
        }

        return response()->json(['nama' => null]);
    }

    /**
     * Halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Ambil data pegawai dari PNS / PPPK berdasarkan NIP
     * (dipanggil dari JavaScript di register.blade)
     */
    public function getPegawai($nip)
    {
        // Cari di tabel PNS dulu
        $pegawai = Pns::where('nip', $nip)->first();
        $jenis = 'pns';

        // Jika tidak ditemukan, cari di tabel PPPK
        if (!$pegawai) {
            $pegawai = Pppk::where('nip', $nip)->first();
            $jenis = 'pppk';
        }

        if ($pegawai) {
            return response()->json([
                'nama' => $pegawai->nama ?? '',
                'email' => $pegawai->email ?? '',
                'jenis_pegawai' => $jenis,
            ]);
        }

        return response()->json([
            'nama' => null,
            'email' => null,
            'jenis_pegawai' => null,
        ]);
    }

    /**
     * Proses register user baru (PNS atau PPPK)
     */
    public function register(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:30',
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cek apakah NIP terdaftar di PNS atau PPPK
        $pegawai = Pns::where('nip', $request->nip)->first();
        $jenisPegawai = 'pns';

        if (!$pegawai) {
            $pegawai = Pppk::where('nip', $request->nip)->first();
            $jenisPegawai = 'pppk';
        }

        // Jika tetap tidak ditemukan
        if (!$pegawai) {
            Alert::error('Registrasi Gagal', 'NIP tidak ditemukan di data PNS atau PPPK.');
            return back()->withInput()->withErrors([
                'nip' => 'NIP tidak terdaftar pada data pegawai manapun.'
            ]);
        }

        // Cek email sesuai data pegawai
        if ($pegawai->email !== $request->email) {
            Alert::error('Registrasi Gagal', 'Email tidak sesuai dengan data pegawai.');
            return back()->withInput()->withErrors([
                'email' => 'Email tidak sesuai dengan data pegawai.'
            ]);
        }

        // Buat user baru
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'nip' => $pegawai->nip,
            'email' => $pegawai->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'jenis_pegawai' => $jenisPegawai, // pastikan kolom ini ada di tabel users
        ]);

        Alert::success('Registrasi Berhasil', 'Akun berhasil dibuat. Silakan login.');
        return redirect()->route('login');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Logout Berhasil', 'Sampai jumpa lagi!');
        return redirect()->route('login');
    }
}
