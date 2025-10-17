{{-- resources/views/admin/pesan/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pesan - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  {{-- HEADER --}}
  <header class="bg-gradient-to-r from-sky-600 to-amber-400 p-4 flex items-center justify-between shadow-md">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-sky-600 font-extrabold text-lg">KN</div>
      <div>
        <div class="text-white font-bold text-lg">Kawa-Nda</div>
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
    <aside class="w-64 bg-white shadow-sm p-6 flex flex-col">
      <div class="flex-1">
        <ul class="space-y-4">
          <li>
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-sky-700 hover:bg-sky-50' }}">🏠 Dashboard</a>
          </li>
          <li>
            <a href="{{ route('admin.data.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.data.index') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">📂 Data</a>
          </li>
          <li>
            <a href="{{ route('admin.data.create') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">➕ Tambah Data</a>
          </li>
          <li>
            <a href="{{ route('admin.laporan.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">📑 Laporan</a>
          </li>
          <li>
            <a href="{{ route('admin.pesan.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">💬 Permintaan Data</a>
          </li>

          {{-- Logout --}}
          <li>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
              <button id="logout-btn" type="button" class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-3 font-semibold">🚪 Logout</button>
            </form>
          </li>
        </ul>
      </div>
      <div class="mt-6 text-center text-xs text-gray-400">© {{ date('Y') }} Kawa-Nda</div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 space-y-6">
      {{-- tampilkan partial sesuai tipe --}}
      @if($tipe === 'kenaikan_pangkat')
        @includeIf('admin.pesan.partials.kenaikan_pangkat', ['data' => $data])
      @elseif($tipe === 'mutasi_jabatan')
        @includeIf('admin.pesan.partials.mutasi_jabatan', ['data' => $data])
      @elseif($tipe === 'mutasi_unor')
        @includeIf('admin.pesan.partials.mutasi_unor', ['data' => $data])
      @elseif($tipe === 'update_profil')
        {{-- Hanya include partial (partial menampilkan: Data Pegawai, Alasan, Dokumen) --}}
        @includeIf('admin.pesan.partials.update_profil', ['data' => $data])
      @elseif($tipe === 'pesan')
        <div class="p-4 bg-gray-50 border rounded">
          <strong>Isi Pesan:</strong>
          <p class="mt-2 text-gray-700">{{ $data->isi ?? '-' }}</p>
        </div>
      @else
        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
          <p class="text-yellow-800 font-medium">⚠️ Tipe tidak dikenal atau belum didukung.</p>
        </div>
      @endif

  <script>
    // logout confirm
    document.getElementById('logout-btn')?.addEventListener('click', function() {
      if (confirm('Yakin ingin logout?')) {
        document.getElementById('logout-form').submit();
      }
    });
  </script>
</body>
</html>
