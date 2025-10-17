<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Permohonan Mutasi Unor - Kawa-Nda</title>
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
          <li>
            <a href="{{ route('user.dashboard') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              <span>🏠</span> Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('user.profile.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              <span>👤</span> Profil Saya
            </a>
          </li>
          <li>
            <a href="{{ route('user.layanan.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              <span>📂</span> Update Data Kepegawaian
            </a>
          </li>
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
      <h2 class="text-2xl font-bold text-gray-700">PERMOHONAN MUTASI UNOR</h2>
      <p class="text-gray-600">Silakan isi formulir berikut untuk permohonan mutasi unit organisasi.</p>

      {{-- Pesan sukses --}}
      @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded">
          {{ session('success') }}
        </div>
      @endif

      {{-- Pesan error --}}
      @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- FORM --}}
      <form action="{{ route('user.layanan.mutasi-unor.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- Identitas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" value="{{ $pegawai->nama ?? '-' }}"
                   class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <input type="hidden" name="nama" value="{{ $pegawai->nama ?? '-' }}">
          </div>

          <div>
            <label class="block font-medium mb-1">NIP</label>
            <input type="text" value="{{ $pegawai->nip ?? '-' }}"
                   class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <input type="hidden" name="nip" value="{{ $pegawai->nip ?? '-' }}">
          </div>

          <div>
            <label class="block font-medium mb-1">Pangkat / Golongan</label>
            <input type="text" value="{{ $pegawai->gol_akhir_nama ?? '-' }}"
                   class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <input type="hidden" name="gol_akhir_nama" value="{{ $pegawai->gol_akhir_nama ?? '-' }}">
          </div>

          <div>
            <label class="block font-medium mb-1">Jabatan</label>
            <input type="text" value="{{ $pegawai->jabatan ?? '-' }}"
                   class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <input type="hidden" name="jabatan" value="{{ $pegawai->jabatan_nama ?? '-' }}">
          </div>

          <div>
            <label class="block font-medium mb-1">Unit Asal</label>
            <input type="text" value="{{ $pegawai->unor ?? '-' }}"
                   class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            <input type="hidden" name="unor" value="{{ $pegawai->unor ?? '-' }}">
          </div>

          <div>
            <label class="block font-medium mb-1">Unit Tujuan</label>
            <input type="text" name="unor_tujuan" value="{{ old('unor_tujuan') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
          </div>

          <div>
            <label class="block font-medium mb-1">TMT Jabatan Baru</label>
            <input type="date" name="tmt_jabatan_baru" value="{{ old('tmt_jabatan_baru') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
          </div>
        </div>

        {{-- Bukti Dukung --}}
        <div class="space-y-3">
          <label class="block font-semibold text-gray-700">Bukti Dukung</label>

          <div>
            <label class="block mb-1 text-sm">SK Mutasi</label>
            <input type="file" name="sk_mutasi" class="w-full border rounded-lg p-2 bg-gray-50">
          </div>

          <div>
            <label class="block mb-1 text-sm">SK Pelantikan <span class="text-xs text-gray-500">(opsional)</span></label>
            <input type="file" name="sk_pelantikan" class="w-full border rounded-lg p-2 bg-gray-50">
          </div>

          <div>
            <label class="block mb-1 text-sm">Berita Acara Pelantikan <span class="text-xs text-gray-500">(opsional)</span></label>
            <input type="file" name="berita_acara_pelantikan" class="w-full border rounded-lg p-2 bg-gray-50">
          </div>

          <div>
            <label class="block mb-1 text-sm">SK Jabatan</label>
            <input type="file" name="sk_jabatan" class="w-full border rounded-lg p-2 bg-gray-50">
          </div>

          <div>
            <label class="block mb-1 text-sm">SPMT OPD Baru</label>
            <input type="file" name="spmt" class="w-full border rounded-lg p-2 bg-gray-50">
          </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-4">
          <button type="reset" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">Reset</button>
          <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">Kirim Permohonan</button>
        </div>
      </form>
    </main>
  </div>

  {{-- Script --}}
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
