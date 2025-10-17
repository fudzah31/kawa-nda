{{-- resources/views/admin/laporan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laporan Data Pegawai - Kawa-Nda</title>

  {{-- Tailwind + SweetAlert2 + DataTables --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

  <style>
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .submenu.open {
      max-height: 300px;
    }
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.12); }

    /* DataTables + Tailwind tweaks */
    .dataTables_wrapper .dataTables_length select {
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      padding: 0.25rem 0.5rem;
      background: white;
    }
    .dataTables_wrapper .dataTables_filter input { display: none !important; }
    table.dataTable tbody tr:hover { background-color: #e0f2fe; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border-radius: 0.375rem;
      border: 1px solid #e5e7eb;
      padding: 4px 8px;
      margin: 0 4px;
      color: #374151 !important;
      background: #fff;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: #2563eb !important;
      color: #fff !important;
      border-color: #2563eb;
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
    {{-- SIDEBAR --}}
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
            <a href="{{ route('admin.data.create') }}" 
              class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
              ➕ Tambah Data
            </a>
          </li>

          {{-- Laporan --}}
          <li>
            <a href="{{ route('admin.laporan.index') }}" 
              class="block px-4 py-3 rounded-lg bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold">
              📑 Laporan
            </a>
          </li>

          {{-- Permintaan Data --}}
          <li>
            <a href="{{ route('admin.pesan.index') }}" 
              class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
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
      <h2 class="text-2xl font-bold text-gray-700">Laporan Data Pegawai</h2>
      <p class="text-gray-500">Kelola laporan pegawai, pilih format ekspor sesuai kebutuhan.</p>

      <div class="bg-white p-6 rounded-2xl shadow space-y-6">
        {{-- Filter + Export --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <form id="filter-form" method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center gap-3">
            <label for="jenis" class="text-sm text-gray-600">Filter Jenis Pegawai</label>
            <select name="jenis" id="jenis" onchange="document.getElementById('filter-form').submit()" class="border rounded px-3 py-2 text-sm">
              <option value="">-- Semua --</option>
              <option value="PNS" {{ request('jenis') == 'PNS' ? 'selected' : '' }}>PNS</option>
              <option value="PPPK" {{ request('jenis') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
            </select>
          </form>

          <div class="flex items-center gap-3">
            @php
              $qs = request()->only('jenis');
              $qsString = count($qs) ? ('?' . http_build_query($qs)) : '';
            @endphp

            <a href="{{ route('admin.laporan.export', 'csv') }}{{ $qsString }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Export CSV</a>
            <a href="{{ route('admin.laporan.export', 'excel') }}{{ $qsString }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">Export Excel</a>
          </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-4">
          <table id="pegawaiTable" class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gradient-to-r from-blue-600 to-yellow-400 text-white">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">NIP</th>
                <th class="px-4 py-2 text-left">NIK</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Jabatan</th>
                <th class="px-4 py-2 text-left">Jenis</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pegawai as $row)
                <tr>
                  <td class="px-4 py-2"></td>
                  <td class="px-4 py-2">{{ $row->nip ?? '-' }}</td>
                  <td class="px-4 py-2">{{ $row->nik ?? '-' }}</td>
                  <td class="px-4 py-2">{{ $row->nama }}</td>
                  <td class="px-4 py-2">{{ $row->jabatan ?? '-' }}</td>
                  <td class="px-4 py-2">{{ $row->jenis_data }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  {{-- SCRIPTS --}}
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('#pegawaiTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        columnDefs: [{ orderable: false, searchable: false, targets: 0 }],
        dom: '<"flex items-center justify-between mb-2"<"dataTables_length"l>>t<"flex items-center justify-between mt-2"<"text-sm text-gray-600"i><"dataTables_paginate"p>>',
        language: {
          lengthMenu: "_MENU_ entries",
          paginate: { previous: "Previous", next: "Next" },
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        }
      });

      table.on('draw.dt', function() {
        var info = table.page.info();
        table.column(0, {page: 'current'}).nodes().each(function(cell, i) {
          cell.innerHTML = info.start + i + 1;
        });
      });
      table.draw();
    });

    // Logout confirm
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

    // Dropdown menu Data
    const dropdownBtn = document.getElementById('dataDropdownBtn');
    const dropdown = document.getElementById('dataDropdown');
    const dropdownIcon = document.getElementById('dataDropdownIcon');
    dropdownBtn.addEventListener('click', () => {
      dropdown.classList.toggle('open');
      dropdownIcon.classList.toggle('rotate-180');
    });

    // Otomatis buka dropdown Data di halaman Laporan
    dropdown.classList.add('open');
    dropdownIcon.classList.add('rotate-180');
  </script>
</body>
</html>
