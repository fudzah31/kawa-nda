{{-- resources/views/admin/data/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pegawai - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
    .sidebar-link { transition: all 0.3s ease; }
    .sidebar-link:hover { 
      transform: translateX(8px);
      background: linear-gradient(to right, #2563eb, #facc15);
      color: white;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

 {{-- HEADER --}}
  <header class="bg-gradient-to-r from-sky-600 to-amber-400 p-4 flex items-center justify-between shadow-md">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-sky-600 font-extrabold text-lg">KN</div>
      <div>
        <div class="text-white font-bold text-lg text-shadow">Kawa-Nda</div>
        <div class="text-white text-sm opacity-90">Kelola data pegawai BKD dengan mudah ✨</div>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <div class="text-right text-white">
        <div class="font-semibold">{{ Auth::user()->name }}</div>
        <div class="text-xs opacity-90">{{ Auth::user()->role }}</div>
      </div>
      <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-bold text-sky-600">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </div>
    </div>
  </header>
  
  <div class="flex min-h-screen">
    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-sm p-6 flex flex-col justify-between">
      <div>
        <ul class="space-y-4">
          <li>
            <a href="{{ route('admin.dashboard') }}" 
              class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-sky-700 hover:bg-sky-50' }}">
              🏠 Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('admin.data.index') }}" 
              class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.data.index') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">
              📂 Data
            </a>
          </li>
          <li>
            <a href="{{ route('admin.data.create') }}" 
              class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.data.create') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">
              ➕ Tambah Data
            </a>
          </li>
          <li>
            <a href="{{ route('admin.laporan.index') }}" 
              class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.laporan.index') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">
              📑 Laporan
            </a>
          </li>
          <li>
            <a href="{{ route('admin.pesan.index') }}" 
              class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.pesan.index') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">
              💬 Permintaan Data
            </a>
          </li>
        </ul>

        {{-- Tombol Logout --}}
        <div class="mt-6">
          <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="button" id="logout-btn"
              class="w-full text-left sidebar-link block px-5 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">
              🚪 Logout
            </button>
          </form>
        </div>
      </div>

      {{-- Footer Sidebar --}}
      <div class="text-center text-xs text-gray-400 mt-6">
        © {{ date('Y') }} Kawa-Nda
      </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-2xl font-bold text-gray-700">Detail Pegawai</h2>
          <p class="text-gray-500">Informasi lengkap mengenai pegawai.</p>
        </div>
        <div>
          <a href="{{ route('admin.data.index') }}" 
             class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow">
            ⬅️ Kembali
          </a>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow p-6">
        {{-- Kondisi tampilkan partial sesuai jenis pegawai --}}
        @if (strtolower($jenis) === 'pns')
          @include('admin.data.partials._pns', ['pegawai' => $pegawai])
        @elseif (strtolower($jenis) === 'pppk')
          @include('admin.data.partials._pppk', ['pegawai' => $pegawai])
        @else
          <p class="text-red-600 font-semibold">Jenis pegawai tidak dikenali.</p>
        @endif
      </div>
    </main>
  </div>

  <script>
    // Logout confirmation
    document.getElementById('logout-btn').addEventListener('click', function() {
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Sesi Anda akan berakhir.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('logout-form').submit();
        }
      })
    });
  </script>
</body>
</html>
