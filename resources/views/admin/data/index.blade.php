{{-- resources/views/admin/data/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pegawai - Kawa-Nda</title>

  <!-- Tailwind + SweetAlert2 + DataTables -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.12); }
    .card-anim { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-anim:hover { transform: translateY(-6px); box-shadow: 0 18px 35px rgba(15,23,42,0.08); }

    /* Border tabel */
    table.dataTable th, table.dataTable td {
      border: 1px solid #d1d5db;
      padding: 8px 12px;
    }
    table.dataTable { border-collapse: collapse !important; }

    /* Striped row */
    table.dataTable tbody tr:nth-child(odd) { background-color: #f9fafb !important; }
    table.dataTable tbody tr:nth-child(even) { background-color: #ffffff !important; }

    /* Hover effect */
    table.dataTable tbody tr:hover { background-color: #bfdbfe !important; transition: background-color 0.15s ease-in-out; }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate { margin-top: 1rem; text-align: center; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      display: inline-block; margin: 0 2px; padding: 6px 12px;
      border-radius: 6px; border: 1px solid #d1d5db; background-color: #fff;
      color: #374151; font-size: 14px; cursor: pointer; transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background-color: #3b82f6; color: #fff !important; border-color: #2563eb;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background-color: #2563eb !important; color: #fff !important; border-color: #2563eb; font-weight: bold;
    }

    .dataTables_wrapper .dataTables_info { margin-top: 1rem; text-align: left; color: #374151; }

    /* Search */
    .dataTables_wrapper .dataTables_filter { margin-bottom: 1rem; float: none; text-align: right; }
    .dataTables_wrapper .dataTables_filter label { font-size: 14px; font-weight: 500; color: #374151; }
    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #d1d5db; border-radius: 10px; padding: 8px 14px;
      margin-left: 8px; width: 260px; background-color: #fff; outline: none; transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
    }

    /* Sidebar submenu */
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
    {{-- SIDEBAR (disamakan dengan dashboard) --}}
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
    <main class="flex-1 p-6 space-y-6">
      <div>
        <h2 class="text-2xl font-bold text-gray-700">Data Pegawai</h2>
        <p class="text-gray-500">Berikut adalah daftar data pegawai yang sudah tersimpan.</p>
      </div>

      {{-- Filter + Search --}}
      <div class="bg-white p-4 rounded-xl shadow mb-4 flex justify-between items-center flex-wrap gap-3">
        <div>
          <label for="filterJenis" class="block text-sm font-medium text-gray-700 mb-2">Filter Jenis Pegawai</label>
          <select id="filterJenis" class="border border-gray-300 rounded-lg p-2 w-60">
            <option value="">-- Semua --</option>
            <option value="PNS">PNS</option>
            <option value="PPPK">PPPK</option>
          </select>
        </div>
        <div id="pegawaiTable_filter"></div>
      </div>

      {{-- Tabel --}}
      <div class="bg-white rounded-2xl shadow p-5 card-anim overflow-x-auto">
        <table id="pegawaiTable" class="min-w-full border border-gray-300 rounded-lg">
          <thead class="bg-gradient-to-r from-blue-600 to-yellow-400 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">Nama Pegawai</th>
              <th class="px-4 py-2 text-left">NIP</th>
              <th class="px-4 py-2 text-left">Jabatan</th>
              <th class="px-4 py-2 text-left">Jenis</th>
              <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </main>
  </div>

  {{-- SCRIPT --}}
  <script>
    $(document).ready(function() {
      let baseUrl = "{{ url('admin/data') }}";

      let table = $('#pegawaiTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
          url: "{{ route('admin.data.list') }}",
          dataSrc: 'data',
          data: function (d) {
            d.jenis = $('#filterJenis').val();
          }
        },
        columns: [
          { data: null, orderable: false, searchable: false,
            render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
          { data: 'nama', defaultContent: '' },
          { data: 'nip', defaultContent: '' },
          { data: 'jabatan', defaultContent: '' },
          { data: 'jenis', defaultContent: '' },
          { 
            data: null, 
            orderable: false, 
            searchable: false,
            render: (data, type, row) => {
              let jenis = encodeURIComponent(row.jenis || '');
              let id = row.id || '';

              return `
                <div class="flex items-center justify-center gap-2">
                  <a href="${baseUrl}/${jenis}/${id}" 
                     class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Detail
                  </a>

                  <a href="${baseUrl}/${jenis}/${id}/edit" 
                     class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                    Edit
                  </a>

                  <button type="button"
                          class="hapus-btn px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                          data-id="${id}" 
                          data-jenis="${jenis}">
                    Hapus
                  </button>
                </div>
              `;
            } 
          }
        ]
      });

      // Filter jenis
      $('#filterJenis').on('change', () => table.ajax.reload());

      // Tombol hapus dengan SweetAlert2
      $(document).on('click', '.hapus-btn', function() {
        let id = $(this).data('id');
        let jenis = $(this).data('jenis');
        let url = `${baseUrl}/${jenis}/${id}`;

        Swal.fire({
          title: "Yakin ingin menghapus data ini?",
          text: "Data yang dihapus tidak dapat dikembalikan.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, hapus!",
          cancelButtonText: "Batal"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              type: "DELETE",
              data: { _token: "{{ csrf_token() }}" },
              success: function() {
                Swal.fire("Terhapus!", "Data berhasil dihapus.", "success");
                table.ajax.reload();
              },
              error: function() {
                Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data.", "error");
              }
            });
          }
        });
      });
    });

    // Dropdown Menu Data
    const dropdownBtn = document.getElementById("dataDropdownBtn");
    const dropdown = document.getElementById("dataDropdown");
    const dropdownIcon = document.getElementById("dataDropdownIcon");

    dropdownBtn.addEventListener("click", () => {
      dropdown.classList.toggle("open");
      dropdownIcon.classList.toggle("rotate-180");
    });

    // Logout
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
