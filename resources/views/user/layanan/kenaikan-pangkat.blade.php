<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kenaikan Pangkat - Kawa-Nda</title>
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
              🏠 Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('user.profile.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              👤 Profil Saya
            </a>
          </li>
          <li>
            <a href="{{ route('user.layanan.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              📂 Update Data Kepegawaian
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
      <h2 class="text-2xl font-bold text-gray-700">Kenaikan Pangkat</h2>
      <p class="text-gray-600">Silakan isi formulir berikut untuk pengajuan kenaikan pangkat.</p>

      {{-- ALERT SWEETALERT --}}
      @if(session('success'))
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
          })
        </script>
      @endif
      @if(session('error'))
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}'
          })
        </script>
      @endif

      {{-- ERROR VALIDASI --}}
      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li>• {{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- FORM --}}
      <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('user.layanan.kenaikan-pangkat.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Data Pegawai --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="block text-sm font-medium">NIP</label>
              <input type="text" name="nip" value="{{ Auth::user()->nip ?? old('nip') }}" 
                     class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div>
              <label class="block text-sm font-medium">Nama</label>
              <input type="text" name="nama" value="{{ Auth::user()->name ?? old('nama') }}" 
                     class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div>
              <label class="block text-sm font-medium">Jabatan</label>
              <input type="text" name="jabatan" value="{{ old('jabatan') }}" 
                     class="w-full border rounded p-2" required>
            </div>
            <div>
              <label class="block text-sm font-medium">Pangkat/Golongan Terakhir</label>
              <input type="text" name="pangkat" value="{{ old('pangkat') }}" 
                     class="w-full border rounded p-2" required>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium">Unit Organisasi</label>
              <input type="text" name="unor" value="{{ old('unor') }}" 
                     class="w-full border rounded p-2" required>
            </div>
          </div>

          {{-- Upload Dokumen --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Upload SK Pangkat Terakhir (PDF/JPG)</label>
            <input type="file" name="sk_pangkat" accept=".pdf,.jpg,.jpeg,.png" 
                   class="w-full border rounded p-2" required>
          </div>
          <div class="mb-6">
            <label class="block text-sm font-medium">Upload SPMT (PDF/JPG)</label>
            <input type="file" name="spmt" accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border rounded p-2" required>
          </div>

          {{-- Tombol Submit --}}
          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
              Ajukan
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>

  {{-- Animasi + Logout --}}
  <script>
    // animasi muncul
    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });

    // konfirmasi logout
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
