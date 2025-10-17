{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Kawa-Nda</title>

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
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .submenu.open {
      max-height: 300px;
    }
    .clickable { cursor: pointer; }
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
    <main class="flex-1 p-6">
      <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Halo, selamat datang 👋</h1>
      <p class="text-sm text-gray-500 mb-6">Lihat ringkasan cepat data pegawai di bawah ini.</p>

      {{-- TOP STAT CARDS --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div id="cardPns" class="rounded-2xl card-anim p-5 bg-gradient-to-r from-sky-500 to-indigo-600 text-white stripe clickable hover:ring-2 hover:ring-sky-300 transition">
          <div class="text-sm opacity-90">Data PNS</div>
          <div class="text-3xl font-extrabold mt-2">{{ number_format($pnsCount ?? 0) }}</div>
        </div>

        <div id="cardPppk" class="rounded-2xl card-anim p-5 bg-gradient-to-r from-emerald-400 to-green-600 text-white stripe clickable hover:ring-2 hover:ring-green-300 transition">
          <div class="text-sm opacity-90">Data PPPK</div>
          <div class="text-3xl font-extrabold mt-2">{{ number_format($pppkCount ?? 0) }}</div>
        </div>

        <div class="rounded-2xl card-anim p-5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white stripe">
          <div class="text-sm opacity-90">Total Pegawai</div>
          <div class="text-3xl font-extrabold mt-2">{{ number_format($totalCount ?? 0) }}</div>
        </div>
      </div>

      {{-- CHARTS --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- PNS vs PPPK --}}
        <div id="statPegawaiCard" class="col-span-2 bg-white p-5 rounded-2xl shadow-sm card-anim clickable hover:ring-2 hover:ring-sky-300 transition">
          <h3 class="text-lg font-semibold text-slate-700 mb-3">Statistik PNS & PPPK</h3>
          <div class="h-64">
            <canvas id="pegawaiChart"></canvas>
          </div>
        </div>

        {{-- Statistik Tenaga --}}
        <div id="statTenagaCard" 
             class="bg-white p-5 rounded-2xl shadow-sm card-anim clickable hover:ring-2 hover:ring-amber-300 transition">
          <h3 class="text-lg font-semibold text-slate-700 mb-3">Statistik Tenaga</h3>

          <div class="flex flex-col items-center gap-5">
            <div class="w-40 h-40">
              <canvas id="statsChart"></canvas>
            </div>

            {{-- List kategori --}}
            <ul class="w-full space-y-3">
              @foreach($kategoriCounts as $k => $v)
              <li class="flex items-center justify-between px-2 py-1 hover:bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                  <span class="w-3 h-3 rounded-full" style="background:
                    {{ $loop->index==0 ? '#2563eb' : ($loop->index==1 ? '#22c55e' : ($loop->index==2 ? '#9333ea' : ($loop->index==3 ? '#facc15' : '#ef4444')) ) }};">
                  </span>
                  <span class="text-sm font-medium text-slate-700">{{ $k }}</span>
                </div>
                <span class="font-semibold text-slate-700">{{ number_format($v) }}</span>
              </li>
              @endforeach
            </ul>
          </div>

          <div class="mt-4 text-xs text-gray-400">Catatan: "Tenaga Lainnya" adalah kategori selain 4 utama.</div>
        </div>
      </div>
    </main>
  </div>

  {{-- SCRIPTS --}}
  <script>
    // Chart: PNS & PPPK
    new Chart(document.getElementById("pegawaiChart"), {
      type: "bar",
      data: {
        labels: ["PNS", "PPPK"],
        datasets: [{
          data: [{{ $pnsCount ?? 0 }}, {{ $pppkCount ?? 0 }}],
          backgroundColor: ["#2563eb","#22c55e"],
          borderRadius: 8
        }]
      },
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Chart: Tenaga
    new Chart(document.getElementById("statsChart"), {
      type: "doughnut",
      data: {
        labels: {!! json_encode(array_keys($kategoriCounts ?? [])) !!},
        datasets: [{
          data: {!! json_encode(array_values($kategoriCounts ?? [])) !!},
          backgroundColor: ["#2563eb","#22c55e","#9333ea","#facc15","#ef4444"]
        }]
      },
      options: { plugins: { legend: { display: false } } }
    });

    // Klik card → pindah halaman
    document.getElementById("statTenagaCard").addEventListener("click", () => {
      window.location.href = "{{ route('admin.data.kategori.index') }}";
    });

    document.getElementById("statPegawaiCard").addEventListener("click", () => {
      window.location.href = "{{ route('admin.data.index') }}";
    });

    document.getElementById("cardPns").addEventListener("click", () => {
      window.location.href = "{{ route('admin.data.index') }}";
    });

    document.getElementById("cardPppk").addEventListener("click", () => {
      window.location.href = "{{ route('admin.data.index') }}";
    });

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
  </script>
</body>
</html>
