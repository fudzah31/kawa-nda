{{-- resources/views/user/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard - Kawa-Nda</title>

  {{-- Tailwind + Chart.js + SweetAlert2 --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
    .sidebar-link { transition: all 0.3s ease; }
    .sidebar-link:hover {
      transform: translateX(8px);
      background: linear-gradient(to right, #2563eb, #facc15);
      color: white;
    }
    .text-empty { color: #9ca3af; font-style: italic; }
    .fade-slide { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .fade-slide.show { opacity: 1; transform: translateY(0); }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  {{-- HEADER --}}
  <header class="bg-gradient-to-r from-blue-600 to-yellow-400 p-4 flex justify-between items-center shadow">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-lg">
        KN
      </div>
      <div class="text-white">
        <div class="font-bold text-lg text-shadow">Kawa-Nda</div>
        <div class="text-sm opacity-90 text-shadow-sm">Sistem Manajemen Kepegawaian</div>
      </div>
    </div>

    <div class="flex items-center gap-4 text-white">
      <div class="text-right">
        <div class="font-semibold">{{ Auth::user()->name ?? '-' }}</div>
        <div class="text-xs opacity-90">{{ Auth::user()->role ?? '-' }}</div>
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
               class="sidebar-link block px-5 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
              🏠 Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('user.profile.index') }}"
               class="sidebar-link block px-5 py-3 rounded-lg {{ request()->routeIs('user.profile.*') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
              👤 Profil Saya
            </a>
          </li>
          <li>
            <a href="{{ route('user.layanan.index') }}"
               class="sidebar-link block px-5 py-3 rounded-lg {{ request()->routeIs('user.layanan.*') ? 'bg-gradient-to-r from-blue-600 to-yellow-400 text-white font-semibold' : '' }}">
              📂 Update Data Kepegawaian
            </a>
          </li>
          <li>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="button" id="logout-btn"
                class="w-full text-left sidebar-link block px-5 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-transform transform hover:scale-105">
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
      <h2 class="text-2xl font-bold text-gray-700">Selamat Datang di Dashboard User</h2>
      <p class="text-gray-600">Gunakan menu di samping untuk mengelola profil dan layanan kepegawaian Anda.</p>

      {{-- PROFIL WRAPPER --}}
      <div id="pegawai-wrapper" class="space-y-6">
        @if (isset($pegawai) && $pegawai)
          @includeWhen(View::exists('user.partials.profil-card'), 'user.partials.profil-card', ['pegawai' => $pegawai, 'data' => $data ?? null])
        @else
          <div class="bg-white p-6 rounded-2xl shadow">
            <div class="text-gray-700 font-semibold">Data pegawai belum tersedia.</div>
            <div class="text-sm text-gray-500 mt-1">Silakan hubungi administrator atau periksa profil Anda.</div>
          </div>
        @endif
      </div>

      {{-- DETAIL WRAPPER --}}
      <div id="pegawai-detail" class="space-y-6">
        @if (isset($pegawai) && $pegawai)
          @includeWhen(View::exists('user.partials.profil-detail'), 'user.partials.profil-detail', ['pegawai' => $pegawai, 'data' => $data ?? null])
        @else
          <div class="bg-white p-6 rounded-2xl shadow">
            <div class="text-gray-500">Tidak ada detail pegawai untuk ditampilkan.</div>
          </div>
        @endif
      </div>
    </main>
  </div>

  {{-- SCRIPTS --}}
  <script>
    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });

    setInterval(() => {
      fetch("{{ route('user.dashboard') }}?ajax=1", { credentials: 'same-origin' })
        .then(res => res.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");

          const newWrapper = doc.querySelector("#pegawai-wrapper");
          const newDetail  = doc.querySelector("#pegawai-detail");

          if (newWrapper && newDetail) {
            document.getElementById("pegawai-wrapper").innerHTML = newWrapper.innerHTML;
            document.getElementById("pegawai-detail").innerHTML  = newDetail.innerHTML;
          }
        })
        .catch(() => {});
    }, 30000);

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
