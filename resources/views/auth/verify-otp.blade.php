<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi OTP - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      opacity: 0;
      transition: opacity 0.6s ease-in-out;
      font-family: 'Poppins', sans-serif;
    }
    body.loaded { opacity: 1; }
    body.fade-out { opacity: 0; }
    input.otp-input {
      letter-spacing: 6px;
      text-align: center;
      font-size: 20px;
    }
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
      Masukkan kode OTP yang sudah kami kirimkan ke email Anda untuk melanjutkan reset password.
    </p>
    <button class="mt-8 px-6 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-blue-900 font-semibold shadow-md transition">
      Hubungi Admin
    </button>
  </div>

  <!-- Bagian Kanan -->
  <div class="w-1/2 flex justify-center items-center bg-gray-50 relative">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-[380px] border border-gray-200">
      <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">🔐 Verifikasi OTP</h2>

      <!-- Timer -->
      <div class="text-center text-gray-600 text-sm mb-4">
        Kode OTP berlaku sampai: <span id="countdown">05:00</span>
      </div>

      {{-- Form OTP --}}
      <form method="POST" action="{{ route('password.verifyOtp') }}">
        @csrf
        <input type="text" name="otp" maxlength="6"
          class="otp-input w-full border-2 border-dashed border-blue-500 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-600 transition mb-4"
          placeholder="••••••" required>

        <button type="submit" id="submitBtn"
          class="w-full py-2 rounded-lg bg-gradient-to-r from-blue-600 to-yellow-500 text-white font-semibold shadow-md hover:opacity-90 transition">
          Verifikasi
        </button>
      </form>

      {{-- Kirim ulang OTP --}}
      <form method="POST" action="{{ route('password.resendOtp') }}" class="mt-3">
        @csrf
        <button type="submit"
          class="w-full py-2 rounded-lg bg-gray-500 text-white font-semibold shadow-md hover:bg-gray-600 transition">
          Kirim Ulang OTP
        </button>
      </form>

      <div class="text-center mt-6">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm">
          ⬅ Kembali ke Login
        </a>
      </div>
    </div>
  </div>

  {{-- SweetAlert success --}}
  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500
      });
    </script>
  @endif

  {{-- SweetAlert error --}}
  @if($errors->any())
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ $errors->first() }}',
      });
    </script>
  @endif

  <script>
    // Fade in
    window.addEventListener('DOMContentLoaded', () => {
      document.body.classList.add('loaded');
    });

    // Timer 5 menit
    let timeLeft = 300;
    let countdownEl = document.getElementById("countdown");
    let submitBtn = document.getElementById("submitBtn");

    let timer = setInterval(() => {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;
      countdownEl.textContent =
        (minutes < 10 ? "0" : "") + minutes + ":" +
        (seconds < 10 ? "0" : "") + seconds;

      if (timeLeft <= 0) {
        clearInterval(timer);
        countdownEl.textContent = "Kode OTP kadaluarsa";
        submitBtn.disabled = true;
        submitBtn.classList.add("bg-gray-400", "cursor-not-allowed");
      }
      timeLeft--;
    }, 1000);
  </script>
</body>
</html>
