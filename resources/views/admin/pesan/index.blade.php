{{-- resources/views/admin/pesan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesan - Kawa-Nda</title>

  <!-- Tailwind + Chart.js + SweetAlert2 -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.12); }
    .card-anim { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-anim:hover { transform: translateY(-6px); box-shadow: 0 18px 35px rgba(15,23,42,0.08); }
    .stripe {
      background-image: linear-gradient(135deg, rgba(255,255,255,0.02) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.02) 50%, rgba(255,255,255,0.02) 75%, transparent 75%, transparent);
      background-size: 28px 28px;
    }
    .pill { padding: 0.35rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; }
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .submenu.open {
      max-height: 300px;
    }
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
    {{-- SIDEBAR (sama persis dengan dashboard.blade.php) --}}
    <aside class="w-64 bg-white shadow-sm p-6 flex flex-col">
      <div class="flex-1">
        <ul class="space-y-4">

          {{-- Dashboard --}}
          <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-sky-700 hover:bg-sky-50' }}">
              🏠 Dashboard
            </a>
          </li>

          {{-- Dropdown Data --}}
          <li>
            <button id="dataDropdownBtn"
              class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50 font-medium transition">
              <span>📂 Data</span>
              <svg id="dataDropdownIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            {{-- Submenu Data --}}
            <ul id="dataDropdown" class="submenu pl-6 mt-2 space-y-2 text-sm text-gray-700">
              <li>
                <a href="{{ route('admin.data.index') }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50 {{ request()->routeIs('admin.data.index') ? 'font-semibold text-sky-700' : '' }}">
                   👤 Data Pegawai
                </a>
              </li>
               <li>
                <a href="{{ route('admin.data.unor.index') ?? '#' }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50">
                   🏢 Data UNOR
                </a>
              </li>
              <li>
                <a href="{{ route('admin.data.kategori.index') ?? '#' }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50">
                   💼 Data Kategori Tenaga
                </a>
              </li>
            </ul>
          </li>

          {{-- Tambah Data --}}
          <li>
            <a href="{{ route('admin.data.create') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              ➕ Tambah Data
            </a>
          </li>

          {{-- Laporan --}}
          <li>
            <a href="{{ route('admin.laporan.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              📑 Laporan
            </a>
          </li>

          {{-- Permintaan Data --}}
          <li>
            <a href="{{ route('admin.pesan.index') }}" 
               class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.pesan.index') ? 'bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold' : 'text-gray-700 hover:bg-sky-50' }}">
              💬 Permintaan Data
            </a>
          </li>

          {{-- Logout --}}
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
      <h2 class="text-2xl font-bold text-gray-700">Halaman Pesan</h2>
      <p class="text-gray-500">Daftar permintaan data atau pesan dari pengguna.</p>

      {{-- TABEL DAFTAR PENGAJUAN LAYANAN --}}
      @if($pengajuan_layanan->count() > 0)
      <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Pengajuan Layanan</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">NIP</th>
                <th class="px-4 py-2 border">Jenis Layanan</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pengajuan_layanan as $item)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $item->nama ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $item->nip ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $item->jenis_layanan ?? 'Pesan Umum' }}</td>
                <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                <td class="px-4 py-2 border text-center">

                  {{-- Status badge --}}
                  @php
                    $status = strtolower($item->status ?? 'baru');
                    $statusClasses = [
                      'baru' => 'bg-blue-100 text-blue-700',
                      'dibaca' => 'bg-yellow-100 text-yellow-700',
                      'selesai' => 'bg-green-100 text-green-700',
                      'ditolak' => 'bg-red-100 text-red-700'
                    ];
                    $badgeClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-700';
                  @endphp
                  <span class="px-3 py-1 rounded-full text-xs font-semibold mr-2 {{ $badgeClass }}">
                    {{ ucfirst($status) }}
                  </span>

                  {{-- Detail --}}
                  <a href="{{ route('admin.pesan.show', $item->id) }}?tipe={{ $item->tipe ?? 'pesan' }}"
                      class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2">
                    Detail
                  </a>

                  {{-- Hapus --}}
                  <form action="{{ route('admin.pesan.destroy', $item->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="tipe" value="{{ $item->tipe ?? 'pesan' }}">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                      Hapus
                    </button>
                  </form>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @else
        <p class="text-gray-500">Belum ada pengajuan layanan.</p>
      @endif
    </main>
  </div>

  {{-- SweetAlert: Logout & Dropdown --}}
  <script>
    // Logout confirm
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

    // Dropdown "Data"
    const dropdownBtn = document.getElementById("dataDropdownBtn");
    const dropdown = document.getElementById("dataDropdown");
    const dropdownIcon = document.getElementById("dataDropdownIcon");

    dropdownBtn.addEventListener("click", () => {
      dropdown.classList.toggle("open");
      dropdownIcon.classList.toggle("rotate-180");
    });
  </script>
</body>
</html>
