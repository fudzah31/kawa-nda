{{-- resources/views/admin/data/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pegawai - Kawa-Nda</title>

  {{-- Tailwind + SweetAlert --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.12); }
  </style>
</head>
<body class="bg-gray-50 font-sans leading-normal text-gray-800">

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
    {{-- SIDEBAR (disamakan dengan dashboard) --}}
    <aside class="w-64 bg-white shadow-sm p-6 flex flex-col">
      <div class="flex-1">
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
              class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              ➕ Tambah Data
            </a>
          </li>
          <li>
            <a href="{{ route('admin.laporan.index') }}"
              class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              📑 Laporan
            </a>
          </li>
          <li>
            <a href="{{ route('admin.pesan.index') }}"
              class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              💬 Permintaan Data
            </a>
          </li>
          {{-- Logout sama seperti dashboard --}}
          <li>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
              <button id="logout-btn" type="button"
                class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-3 font-semibold">
                🚪 Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
      <div class="mt-6 text-center text-xs text-gray-400">© {{ date('Y') }} Kawa-Nda</div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-2xl font-bold text-gray-700">Edit Pegawai</h2>
          <p class="text-gray-500">Form untuk mengubah data pegawai.</p>
        </div>
        <div>
          <a href="{{ route('admin.data.index') }}"
             class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow">
            ⬅️ Kembali
          </a>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow p-6">
        {{-- Form Update --}}
        <form action="{{ route('admin.data.update', [$jenis, $jenis === 'pns' ? $pns->id : $pppk->id]) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Partial form --}}
          @if (!empty($partial) && View::exists($partial))
            @if ($jenis === 'pns')
              @include($partial, ['pns' => $pns])
            @elseif ($jenis === 'pppk')
              @include($partial, ['pppk' => $pppk])
            @endif
          @else
            <p class="text-red-600">
              Partial form untuk jenis <strong>{{ $jenis ?? 'tidak diketahui' }}</strong> tidak ditemukan.
            </p>
          @endif

          {{-- Tombol Submit --}}
          <div class="mt-6">
            <button type="submit"
              class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow font-semibold">
              💾 Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>

  {{-- FOOTER --}}
  <footer class="bg-white text-center p-4 shadow mt-6">
    <p class="text-gray-500 text-sm">© {{ date('Y') }} Kawa-Nda. All rights reserved.</p>
  </footer>

  <script>
    // Logout confirmation
    document.getElementById("logout-btn").addEventListener("click", function() {
      Swal.fire({
        title: "Yakin ingin logout?",
        text: "Sesi Anda akan berakhir.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Logout",
        cancelButtonText: "Batal"
      }).then(res => { if (res.isConfirmed) document.getElementById("logout-form").submit(); });
    });
  </script>
</body>
</html>
