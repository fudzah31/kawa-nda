<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate kode OTP 6 digit
        $otp = rand(100000, 999999);

        // Simpan ke session (bukan DB)
        session([
            'reset_email'   => $user->email,
            'otp_code'      => $otp,
            'otp_expires_at'=> Carbon::now()->addMinutes(5), // berlaku 5 menit
        ]);

        // Kirim email
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Kode OTP Reset Password');
        });

        return redirect()->route('password.otp')->with('success', 'Kode OTP sudah dikirim ke email Anda');
    }

    // Kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['msg' => 'Email tidak ditemukan, silakan ulangi proses.']);
        }

        $otp = rand(100000, 999999);

        // Update session OTP
        session([
            'otp_code'      => $otp,
            'otp_expires_at'=> Carbon::now()->addMinutes(5),
        ]);

        // Kirim email OTP baru
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Kode OTP Baru Reset Password');
        });

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda');
    }

    // Tampilkan form OTP
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $otpCode     = session('otp_code');
        $otpExpire   = session('otp_expires_at');
        $resetEmail  = session('reset_email');

        if (!$otpCode || !$otpExpire || !$resetEmail) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan, silakan minta ulang.']);
        }

        if (now()->greaterThan($otpExpire)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa']);
        }

        if ($request->otp != $otpCode) {
            return back()->withErrors(['otp' => 'Kode OTP salah']);
        }

        // OTP valid → tandai terverifikasi
        session(['otp_verified' => true]);

        return redirect()->route('password.reset')->with('success', 'OTP berhasil diverifikasi, silakan ganti password');
    }

    // Tampilkan form reset password
    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['msg' => 'Anda harus verifikasi OTP terlebih dahulu']);
        }

        return view('auth.reset-password');
    }

    // Update password di database
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', session('reset_email'))->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Bersihkan semua session OTP
        session()->forget(['reset_email', 'otp_code', 'otp_expires_at', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah, silakan login dengan password baru');
    }
}
