<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Kawa-Nda</title>
  <!-- CDN Tailwind untuk tampilan sementara -->
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
      Sistem Informasi Pegawai BKD — masuk untuk mengelola dan melihat data pegawai.
    </p>
    <button class="mt-8 px-6 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-blue-900 font-semibold shadow-md transition">
      Pelajari Lebih Lanjut
    </button>
  </div>

  <!-- Bagian Kanan -->
  <div class="w-1/2 flex justify-center items-center bg-gray-50 relative">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-[380px] border border-gray-200">
      <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">Sign In</h2>

      {{-- Pesan error dari session --}}
      @if(session('error'))
        <div class="mb-3 text-red-600 text-sm text-center">{{ session('error') }}</div>
      @endif

      @if(session('success'))
        <div class="mb-3 text-green-600 text-sm text-center">{{ session('success') }}</div>
      @endif

      <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
          <input type="text" id="username" name="username"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 transition"
                 placeholder="Masukkan username atau email" value="{{ old('username') }}" required>
        </div>

        <div class="mb-4">
          <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama</label>
          <input type="text" id="nama" name="nama" readonly
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-600"
                 placeholder="Akan terisi otomatis" value="">
        </div>

        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
          <input type="password" id="password" name="password"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 transition"
                 placeholder="Masukkan password" required>
        </div>

        <!-- Link Lupa Password (ditambahkan) -->
        <div class="mb-6 flex justify-between items-center">
          <div class="text-sm text-gray-600">
            <span>Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-blue-700 font-semibold hover:underline ml-1">Daftar</a>
          </div>

          <div>
            {{-- Pastikan route 'password.email.form' terdaftar di routes/web.php --}}
           <a href="{{ route('password.forgot') }}" class="text-sm text-blue-600 hover:underline">
              Lupa Password?
              </a>

          </div>
        </div>

        <button type="submit"
                class="w-full py-2 rounded-lg bg-gradient-to-r from-blue-600 to-yellow-500 text-white font-semibold shadow-md hover:opacity-90 transition">
          Login
        </button>
      </form>

      <div class="mt-6 text-center text-gray-500 text-xs">
        © 2025 Kawa-Nda. All rights reserved.
      </div>
    </div>
  </div>

  <script>
    // Fade in saat halaman siap
    window.addEventListener('DOMContentLoaded', () => {
      document.body.classList.add('loaded');
    });

    // Fade out sebelum ke halaman register
    const goRegister = document.getElementById('goRegister');
    if (goRegister) {
      goRegister.addEventListener('click', function (event) {
        event.preventDefault();
        document.body.classList.remove('loaded');
        document.body.classList.add('fade-out');
        setTimeout(() => { window.location.href = this.href; }, 600);
      });
    }

    // Auto isi nama berdasarkan username/email
    const usernameInput = document.getElementById('username');
    const namaField = document.getElementById('nama');

    if (usernameInput) {
      usernameInput.addEventListener('input', function () {
        let username = this.value.trim();
        if (username.length > 0) {
          fetch('/get-nama/' + encodeURIComponent(username))
            .then(response => {
              if (!response.ok) throw new Error('Network response not ok');
              return response.json();
            })
            .then(data => {
              // jika API mengembalikan objek { nama: '...' }
              namaField.value = data.nama || "Tidak terdaftar";
            })
            .catch(() => {
              namaField.value = "Error mengambil data";
            });
        } else {
          namaField.value = "";
        }
      });
    }
  </script>
</body>
</html>
