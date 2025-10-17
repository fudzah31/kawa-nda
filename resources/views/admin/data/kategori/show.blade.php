<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kategori - {{ $kategori }} | Kawa-Nda</title>

  <!-- Tailwind + SweetAlert2 -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.12); }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
    .submenu.open { max-height: 300px; }
    .card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card:hover { transform: translateY(-6px); box-shadow: 0 18px 35px rgba(15,23,42,0.08); }
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

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-sm p-6 flex flex-col">
      <div class="flex-1">
        <ul class="space-y-4">
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

            <ul id="dataDropdown" class="submenu pl-6 mt-2 space-y-2 text-sm text-gray-700">
              <li>
                <a href="{{ route('admin.data.index') }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50 {{ request()->routeIs('admin.data.index') ? 'font-semibold text-sky-700' : '' }}">
                   👤 Data Pegawai
                </a>
              </li>
              <li>
                <a href="{{ route('admin.data.unor.index') }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50">
                   🏢 Data UNOR
                </a>
              </li>
              <li>
                <a href="{{ route('admin.data.kategori.index') }}" 
                   class="block px-3 py-2 rounded-md hover:bg-sky-50 font-semibold text-sky-700">
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
            <a href="{{ route('admin.pesan.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
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
    <main class="flex-1 p-6">

      {{-- Header --}}
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-extrabold text-slate-800 mb-2">💼 {{ $kategori }}</h1>
          <p class="text-sm text-gray-500">Detail pegawai dalam kategori ini.</p>
        </div>
        <a href="{{ route('admin.data.kategori.index') }}" 
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 font-medium">← Kembali</a>
      </div>

      {{-- 🔍 Search Bar --}}
      <div class="mb-6">
        <input 
          type="text" 
          id="searchInput" 
          placeholder="🔍 Cari nama, NIP, jabatan, atau UNOR..." 
          class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-sky-400 focus:outline-none"
        >
      </div>

      {{-- Statistik --}}
      <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white shadow-sm p-4 rounded-xl border text-center">
          <p class="text-sm text-gray-500">Jumlah PNS</p>
          <p class="text-3xl font-bold text-sky-600">{{ $pns->count() }}</p>
        </div>
        <div class="bg-white shadow-sm p-4 rounded-xl border text-center">
          <p class="text-sm text-gray-500">Jumlah PPPK</p>
          <p class="text-3xl font-bold text-amber-500">{{ $pppk->count() }}</p>
        </div>
        <div class="bg-white shadow-sm p-4 rounded-xl border text-center">
          <p class="text-sm text-gray-500">Total Pegawai</p>
          <p class="text-3xl font-bold text-emerald-600">{{ $pns->count() + $pppk->count() }}</p>
        </div>
      </div>

      {{-- Daftar Pegawai PNS --}}
      @if($pns->count() > 0)
      <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 border">
        <h2 class="text-lg font-semibold text-sky-700 mb-3">👨‍💼 Pegawai PNS</h2>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="py-2 px-4 text-left">Nama</th>
                <th class="py-2 px-4 text-left">NIP</th>
                <th class="py-2 px-4 text-left">Jabatan</th>
                <th class="py-2 px-4 text-left">UNOR</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pns as $p)
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-2 px-4">{{ $p->nama }}</td>
                  <td class="py-2 px-4">{{ $p->nip }}</td>
                  <td class="py-2 px-4">{{ $p->jabatan ?? '-' }}</td>
                  <td class="py-2 px-4">{{ $p->unor ?? '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endif

      {{-- Daftar Pegawai PPPK --}}
      @if($pppk->count() > 0)
      <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <h2 class="text-lg font-semibold text-amber-700 mb-3">👩‍💼 Pegawai PPPK</h2>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="py-2 px-4 text-left">Nama</th>
                <th class="py-2 px-4 text-left">NIP</th>
                <th class="py-2 px-4 text-left">Jabatan</th>
                <th class="py-2 px-4 text-left">UNOR</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pppk as $p)
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-2 px-4">{{ $p->nama }}</td>
                  <td class="py-2 px-4">{{ $p->nip }}</td>
                  <td class="py-2 px-4">{{ $p->jabatan ?? '-' }}</td>
                  <td class="py-2 px-4">{{ $p->unor ?? '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endif

    </main>
  </div>

  {{-- SCRIPT --}}
  <script>
    // Logout Confirm
    document.getElementById("logout-btn").addEventListener("click", function() {
      Swal.fire({
        title: "Yakin ingin logout?",
        text: "Sesi akan berakhir.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Logout",
        cancelButtonText: "Batal"
      }).then(res => { if (res.isConfirmed) document.getElementById("logout-form").submit(); });
    });

    // Dropdown Menu Data
    const dropdownBtn = document.getElementById("dataDropdownBtn");
    const dropdown = document.getElementById("dataDropdown");
    const dropdownIcon = document.getElementById("dataDropdownIcon");

    dropdownBtn.addEventListener("click", () => {
      dropdown.classList.toggle("open");
      dropdownIcon.classList.toggle("rotate-180");
    });

    // 🔍 Fitur Search Data Pegawai
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
      searchInput.addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        const tables = document.querySelectorAll("table tbody");

        tables.forEach(tbody => {
          const rows = tbody.querySelectorAll("tr");
          rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
          });
        });
      });
    }
  </script>

</body>
</html>
