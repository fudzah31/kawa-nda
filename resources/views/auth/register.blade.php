<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Kawa-Nda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
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
            Buat akun baru untuk mengelola dan melihat data pegawai.
        </p>
        <a href="{{ route('login') }}" id="goLogin"
           class="mt-8 px-6 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-full text-blue-900 font-semibold shadow-md transition">
            Sudah punya akun? Masuk
        </a>
    </div>

    <!-- Bagian Kanan -->
    <div class="w-1/2 flex justify-center items-center bg-gray-50">
        <div class="bg-white shadow-2xl rounded-2xl p-10 w-[420px] border border-gray-200">
            
            <h2 class="text-3xl font-bold text-blue-900 mb-6 text-center">REGISTER</h2>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4" autocomplete="off" novalidate>
                @csrf

                <!-- NIP -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">NIP</label>
                    <input type="text" id="nipInput" name="nip" value="{{ old('nip') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 transition @error('nip') border-red-500 @enderror"
                        placeholder="Masukkan NIP (wajib)">
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" id="namaInput" name="name" value="{{ old('name') }}" required readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                        placeholder="Otomatis terisi dari NIP">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="emailInput" name="email" value="{{ old('email') }}" required readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                        placeholder="Otomatis terisi dari NIP">
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 transition @error('username') border-red-500 @enderror"
                        placeholder="Masukkan username">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                        placeholder="Minimal 6 karakter">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 transition"
                        placeholder="Ulangi password">
                </div>

                <!-- Tombol -->
                <button type="submit"
                    class="w-full py-2 rounded-lg bg-gradient-to-r from-blue-600 to-yellow-500 text-white font-semibold shadow-md hover:opacity-90 transition">
                    Daftar
                </button>
                <p class="text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" id="goLogin2" class="text-blue-700 font-semibold hover:underline">Login</a>
                </p>
            </form>

            <div class="mt-6 text-center text-gray-500 text-xs">
                © 2025 Kawa-Nda. All rights reserved.
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add("loaded");
        });

        function fadeTo(href) {
            document.body.classList.remove("loaded");
            document.body.classList.add("fade-out");
            setTimeout(() => {
                window.location.href = href;
            }, 500);
        }

        document.getElementById("goLogin")?.addEventListener("click", function(e) {
            e.preventDefault();
            fadeTo(this.href);
        });

        document.getElementById("goLogin2")?.addEventListener("click", function(e) {
            e.preventDefault();
            fadeTo(this.href);
        });

        // ✅ Auto isi Nama & Email dari NIP (PNS atau PPPK)
        document.getElementById("nipInput").addEventListener("blur", function () {
            let nip = this.value.trim();
            if (nip !== "") {
                fetch(`/get-pegawai/${nip}`) // ganti endpoint baru
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.nama) {
                            document.getElementById("namaInput").value = data.nama;
                            document.getElementById("emailInput").value = data.email ?? '';
                        } else {
                            document.getElementById("namaInput").value = "";
                            document.getElementById("emailInput").value = "";
                            alert("NIP tidak ditemukan di data PNS maupun PPPK!");
                        }
                    })
                    .catch(err => {
                        console.error("Error:", err);
                    });
            }
        });
    </script>
</body>
</html>
