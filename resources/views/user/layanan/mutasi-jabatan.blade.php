<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mutasi Jabatan - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
    .sidebar-link { transition: all 0.3s ease; }
    .sidebar-link:hover { transform: translateX(6px); background: linear-gradient(to right, #2563eb, #facc15); color: white; }
    .fade-slide { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .fade-slide.show { opacity: 1; transform: translateY(0); }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  {{-- HEADER --}}
  <header class="bg-gradient-to-r from-blue-600 to-yellow-400 p-4 flex justify-between items-center drop-shadow">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-lg">KN</div>
      <div class="text-white">
        <div class="font-bold text-lg text-shadow">Kawa-Nda</div>
        <div class="text-sm opacity-90">Sistem Manajemen Kepegawaian</div>
      </div>
    </div>
    <div class="flex items-center gap-4 text-white">
      <div class="text-right">
        <div class="font-semibold">{{ Auth::user()->name ?? '-' }}</div>
        <div class="text-xs opacity-90 capitalize">{{ Auth::user()->role ?? 'user' }}</div>
      </div>
      <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-bold text-blue-600">
        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
      </div>
    </div>
  </header>

  <div class="flex min-h-screen">
    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-md p-6 flex flex-col justify-between">
      <div>
        <ul class="space-y-5">
          <li><a href="{{ route('user.dashboard') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg"><span>🏠</span> Dashboard</a></li>
          <li><a href="{{ route('user.profile.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg"><span>👤</span> Profil Saya</a></li>
          <li><a href="{{ route('user.layanan.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg"><span>📂</span> Update Data Kepegawaian</a></li>
          <li>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="button" id="logout-btn"
                class="w-full flex items-center gap-2 px-5 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-transform transform hover:scale-105">
                🚪 Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
      <div class="mt-10 text-center text-sm text-gray-500">
        © {{ date('Y') }} Kawa-Nda
      </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 space-y-6 fade-slide">
      <h2 class="text-2xl font-bold text-gray-700">Mutasi Jabatan</h2>
      <p class="text-gray-600">Silakan isi form berikut untuk mengajukan mutasi jabatan.</p>

      @php
        // Ambil data pegawai pertama jika $pegawai adalah Collection
        $dataPegawai = $pegawai instanceof \Illuminate\Support\Collection ? $pegawai->first() : $pegawai;
      @endphp

      {{-- FORM MUTASI JABATAN --}}
      <form action="{{ route('user.layanan.mutasi-jabatan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf

        {{-- Data Otomatis --}}
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700">Nama</label>
            <input type="text" value="{{ $dataPegawai->nama ?? Auth::user()->name ?? '-' }}" disabled class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
          <div>
            <label class="block text-gray-700">NIP</label>
            <input type="text" value="{{ $dataPegawai->nip ?? Auth::user()->nip ?? '-' }}" disabled class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
          <div>
            <label class="block text-gray-700">Golongan Akhir</label>
            <input type="text" value="{{ $dataPegawai->gol_akhir_nama ?? '-' }}" disabled class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
          <div>
            <label class="block text-gray-700">Jabatan Saat Ini</label>
            <input type="text" value="{{ $dataPegawai->jabatan ?? '-' }}" disabled class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
          <div class="col-span-2">
            <label class="block text-gray-700">Unit Organisasi (UNOR)</label>
            <input type="text" value="{{ $dataPegawai->unor ?? '-' }}" disabled class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
        </div>

        {{-- Data Mandiri --}}
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700">UNOR Tujuan</label>
            <input type="text" name="unor_tujuan" class="w-full border rounded-lg p-2" required>
          </div>
          <div>
            <label class="block text-gray-700">TMT Jabatan Baru</label>
            <input type="date" name="tmt_jabatan_baru" class="w-full border rounded-lg p-2">
          </div>
        </div>

        {{-- Upload Dokumen --}}
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700">SK Pelantikan</label>
            <input type="file" name="sk_pelantikan" class="w-full border rounded-lg p-2">
          </div>
          <div>
            <label class="block text-gray-700">Berita Acara Pelantikan</label>
            <input type="file" name="berita_acara_pelantikan" class="w-full border rounded-lg p-2">
          </div>
          <div>
            <label class="block text-gray-700">SK Jabatan</label>
            <input type="file" name="sk_jabatan" class="w-full border rounded-lg p-2">
          </div>
          <div class="col-span-2">
            <label class="block text-gray-700">SPMT</label>
            <input type="file" name="spmt" class="w-full border rounded-lg p-2">
          </div>
        </div>

        <div class="text-right">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">Ajukan</button>
        </div>
      </form>
    </main>
  </div>

  {{-- Script Animasi + Logout --}}
  <script>
    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });
    const logoutBtn = document.getElementById("logout-btn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", function() {
        Swal.fire({
          title: "Yakin ingin logout?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, logout",
          cancelButtonText: "Batal"
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById("logout-form").submit();
          }
        });
      });
    }
  </script>

</body>
</html>
