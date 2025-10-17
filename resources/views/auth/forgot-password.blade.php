<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      opacity: 0;
      transition: opacity 0.6s ease-in-out;
      font-family: 'Poppins', sans-serif;
    }
    body.loaded { opacity: 1; }
    body.fade-out { opacity: 0; }
  </style>
</head>
<body class="h-screen flex">

  <!-- Bagian Kiri -->
  <div class="w-1/2 flex flex-col justify-center items-center bg-gradient-to-br from-blue-900 via-blue-700 to-yellow-500 text-white p-12">
    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-6">
      <span class="text-3xl font-bold text-blue-800">KN</span>
    </div>
    <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">Kawa-Nda</h1>
    <p class="text-lg font-semibold text-yellow-200 mb-4">Karyawan Daerah</p>
    <p class="text-md max-w-md text-center leading-relaxed">
      Sistem Informasi Pegawai BKD — reset password Anda dengan mudah melalui email.
    </p>
    <button class="mt-8 px-6 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-blue-900 font-semibold shadow-md transition">
      Bantuan
    </button>
  </div>

  <!-- Bagian Kanan -->
  <div class="w-1/2 flex justify-center items-center bg-gray-50 relative">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-[380px] border border-gray-200">
      <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">🔑 Lupa Password</h2>
      <p class="text-center text-gray-500 mb-6 text-sm">
        Masukkan email Anda untuk menerima kode OTP reset password.
      </p>

      {{-- Pesan Error --}}
      @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-600 text-sm text-center">
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Pesan Success --}}
      @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-sm text-center">
          {{ session('success') }}
        </div>
      @endif

      {{-- Form --}}
      <form method="POST" action="{{ route('password.sendOtp') }}">
        @csrf
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 transition"
            placeholder="Masukkan email Anda"
            required
          >
        </div>

        <button type="submit"
          class="w-full py-2 rounded-lg bg-gradient-to-r from-blue-600 to-yellow-500 text-white font-semibold shadow-md hover:opacity-90 transition">
          Kirim OTP
        </button>
      </form>

      {{-- Link Kembali --}}
      <div class="text-center mt-6">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm">
          ⬅ Kembali ke Login
        </a>
      </div>

      <div class="mt-6 text-center text-gray-500 text-xs">
        © 2025 Kawa-Nda. All rights reserved.
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      document.body.classList.add('loaded');
    });
  </script>
</body>
</html>
