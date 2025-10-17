<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Data Kepegawaian - Kawa-Nda</title>

  {{-- Tailwind + SweetAlert2 --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
    .sidebar-link { transition: all 0.3s ease; }
    .sidebar-link:hover {
      transform: translateX(6px);
      background: linear-gradient(to right, #2563eb, #facc15);
      color: white;
    }
    .fade-slide {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-slide.show {
      opacity: 1;
      transform: translateY(0);
    }
    .card-anim {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-anim:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    /* Checkbox tampilan 3D dan posisi elegan */
    .checkbox-cell {
      width: 56px;
      text-align: center;
      vertical-align: middle;
    }

    input[type="checkbox"] {
      appearance: none;
      -webkit-appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid #2563eb;
      border-radius: 6px;
      background-color: #f9fafb;
      cursor: pointer;
      position: relative;
      transition: all 0.25s ease;
      box-shadow: 0 1px 2px rgba(0,0,0,0.15);
    }

    input[type="checkbox"]:hover {
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
      transform: scale(1.08);
    }

    input[type="checkbox"]:checked {
      background-color: #2563eb;
      border-color: #1d4ed8;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2) inset;
    }

    input[type="checkbox"]:checked::after {
      content: "✔";
      position: absolute;
      top: 0;
      left: 3px;
      font-size: 14px;
      color: white;
      font-weight: bold;
    }

    /* Efek highlight baris saat dicentang */
    tr.checked-row {
      background-color: #e0ecff !important;
      transition: background-color 0.3s ease;
    }
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
            <a href="{{ route('user.dashboard') }}"
               class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
              🏠 Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('user.profile.index') }}"
               class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg {{ request()->routeIs('user.profile.*') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
              👤 Profil Saya
            </a>
          </li>
          <li>
            <a href="{{ route('user.layanan.index') }}"
               class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg {{ request()->routeIs('user.layanan.*') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
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
      <h2 class="text-2xl font-bold text-gray-700">Update Data Kepegawaian</h2>

      {{-- GRID LAYANAN --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Card Kenaikan Pangkat --}}
        <div class="bg-white rounded-2xl p-6 shadow card-anim">
          <div class="flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <div>
              <h3 class="text-lg font-bold text-gray-800">Kenaikan Pangkat</h3>
              <p class="text-gray-600 text-sm">Ajukan permohonan kenaikan pangkat pegawai.</p>
            </div>
          </div>
          <a href="{{ route('user.layanan.kenaikan-pangkat') }}"
             class="mt-6 block text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
            Ajukan
          </a>
        </div>

        {{-- Card Mutasi UNOR --}}
        <div class="bg-white rounded-2xl p-6 shadow card-anim">
          <div class="flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-5m0 0l-6-6-4 4-6-6-6 6" />
            </svg>
            <div>
              <h3 class="text-lg font-bold text-gray-800">Permohonan Mutasi UNOR</h3>
              <p class="text-gray-600 text-sm">Ajukan mutasi antar unit organisasi.</p>
            </div>
          </div>
          <a href="{{ route('user.layanan.mutasi-unor') }}"
             class="mt-6 block text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition transform hover:scale-105">
            Ajukan
          </a>
        </div>

        {{-- Card Mutasi Jabatan --}}
        <div class="bg-white rounded-2xl p-6 shadow card-anim">
          <div class="flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2h5a1 1 0 011 1v3H3V8a1 1 0 011-1h5zm-6 6h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z" />
            </svg>
            <div>
              <h3 class="text-lg font-bold text-gray-800">Permohonan Mutasi Jabatan</h3>
              <p class="text-gray-600 text-sm">Ajukan mutasi untuk perubahan jabatan.</p>
            </div>
          </div>
          <a href="{{ route('user.layanan.mutasi-jabatan') }}"
             class="mt-6 block text-center bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition transform hover:scale-105">
            Ajukan
          </a>
        </div>

        {{-- Card Update Profil --}}
        <div class="bg-white rounded-2xl p-6 shadow card-anim">
          <div class="flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9.003 9.003 0 01-6.879-3.196z" />
            </svg>
            <div>
              <h3 class="text-lg font-bold text-gray-800">Update Profil Saya</h3>
              <p class="text-gray-600 text-sm">Perbarui data profil pribadi Anda.</p>
            </div>
          </div>
          <a href="{{ route('user.layanan.update-profil') }}"
             class="mt-6 block text-center bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition transform hover:scale-105">
            Ajukan
          </a>
        </div>
      </div>

      {{-- TABEL DAFTAR PENGAJUAN --}}
      <div class="bg-white rounded-2xl shadow p-6 mt-10">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold text-gray-800">Daftar Pengajuan Saya</h3>
          <button id="delete-selected" class="hidden bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm font-semibold transition transform hover:scale-105">
            🗑️ Hapus Terpilih
          </button>
        </div>

        <div class="overflow-x-auto">
          <form id="bulk-delete-form" method="POST" action="{{ route('user.layanan.bulkDelete') }}">
            @csrf
            @method('DELETE')

            <table class="min-w-full border border-gray-200 rounded-lg text-sm">
              <thead class="bg-gray-100">
                <tr>
                  <th class="checkbox-cell border">
                    <input type="checkbox" id="select-all">
                  </th>
                  <th class="px-4 py-2 border text-left font-semibold text-gray-700">No</th>
                  <th class="px-4 py-2 border text-left font-semibold text-gray-700">Jenis Layanan</th>
                  <th class="px-4 py-2 border text-left font-semibold text-gray-700">Tanggal Pengajuan</th>
                  <th class="px-4 py-2 border text-center font-semibold text-gray-700">Status</th>
                  {{-- Kolom Aksi dihapus sesuai permintaan --}}
                </tr>
              </thead>
              <tbody>
                @forelse($pengajuans as $i => $item)
                <tr class="hover:bg-gray-50 transition">
                  <td class="checkbox-cell border">
                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="select-item">
                  </td>
                  <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 border">{{ $item->jenis_layanan }}</td>
                  <td class="px-4 py-2 border">{{ $item->created_at->format('d-m-Y') }}</td>
                  <td class="px-4 py-2 border text-center">
                    @if($item->status == 'pending')
                      <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Pending</span>
                    @elseif($item->status == 'dibaca')
                      <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Dibaca</span>
                    @elseif($item->status == 'selesai')
                      <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Selesai</span>
                    @elseif($item->status == 'ditolak')
                      <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Ditolak</span>
                    @else
                      <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">{{ ucfirst($item->status) }}</span>
                    @endif
                  </td>
                  {{-- Kolom aksi per-baris dihapus --}}
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada pengajuan.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </main>
  </div>

  {{-- Script --}}
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });

    // Logout
    document.getElementById("logout-btn")?.addEventListener("click", () => {
      Swal.fire({
        title: "Yakin ingin logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, logout",
        cancelButtonText: "Batal"
      }).then(result => {
        if (result.isConfirmed) document.getElementById("logout-form").submit();
      });
    });

    // Checkbox logic (bulk delete)
    const selectAll = document.getElementById("select-all");
    const items = document.querySelectorAll(".select-item");
    const deleteSelectedBtn = document.getElementById("delete-selected");

    function toggleDeleteSelected() {
      const anyChecked = [...items].some(i => i.checked);
      deleteSelectedBtn.classList.toggle("hidden", !anyChecked);

      // Efek highlight baris
      items.forEach(i => {
        const row = i.closest("tr");
        if (i.checked) row.classList.add("checked-row");
        else row.classList.remove("checked-row");
      });
    }

    selectAll?.addEventListener("change", e => {
      items.forEach(i => i.checked = e.target.checked);
      toggleDeleteSelected();
    });

    items.forEach(i => i.addEventListener("change", toggleDeleteSelected));

    // Hapus terpilih
    deleteSelectedBtn?.addEventListener("click", () => {
      const checked = [...items].filter(i => i.checked);
      if (!checked.length) return;

      Swal.fire({
        title: `Hapus ${checked.length} data terpilih?`,
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus semua",
        cancelButtonText: "Batal"
      }).then(result => {
        if (result.isConfirmed) document.getElementById("bulk-delete-form").submit();
      });
    });
  </script>
</body>
</html>
