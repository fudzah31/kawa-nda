{{-- resources/views/user/profile/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - Kawa-Nda</title>

  {{-- Tailwind + SweetAlert2 --}}
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
    .text-empty { color: #9ca3af; font-style: italic; }
    .fade-slide {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-slide.show {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

  {{-- HEADER --}}
  <header class="bg-gradient-to-r from-blue-600 to-yellow-400 p-4 flex justify-between items-center shadow">
    <div class="flex items-center gap-4">
      {{-- Logo --}}
      <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-lg shadow-inner">
        KN
      </div>
      <div class="text-white">
        <div class="font-bold text-lg text-shadow">Kawa-Nda</div>
        <div class="text-sm opacity-90">Sistem Manajemen Kepegawaian</div>
      </div>
    </div>

    {{-- User Info --}}
    <div class="flex items-center gap-4 text-white">
      <div class="text-right">
        <div class="font-semibold">{{ e(Auth::user()->name ?? '-') }}</div>
        <div class="text-xs opacity-90">{{ e(Auth::user()->role ?? '-') }}</div>
      </div>
      <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-bold text-blue-600 animate-pulse shadow">
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
      <h2 class="text-2xl font-bold text-gray-700">Profil Saya</h2>
      <p class="text-gray-600">Informasi detail tentang akun Anda.</p>

      {{-- CARD PROFIL --}}
      <div class="bg-white p-6 rounded-2xl shadow space-y-8 transition hover:shadow-lg hover:scale-[1.01]">

        @if(!$pegawai)
          <div class="text-center py-10 text-gray-500 italic">
            Data pegawai belum tersedia atau belum terdaftar di sistem.
          </div>
        @else
          @php
            // Helper fungsi aman
            function safe($val) {
              return isset($val) && $val !== '' ? e($val) : '-';
            }

            $isPppk = $pegawai instanceof \App\Models\Pppk;
            $tipe = $isPppk ? 'PPPK' : 'PNS';

            $sections = [
              'Informasi Utama' => [
                'NIP' => safe($pegawai->nip ?? null),
                'Nama Lengkap' => safe($pegawai->nama ?? null),
                'Gelar Depan' => safe($pegawai->gelar_depan ?? null),
                'Gelar Belakang' => safe($pegawai->gelar_belakang ?? null),
                'Tempat Lahir' => safe($pegawai->tempat_lahir ?? null),
                'Tanggal Lahir' => safe($pegawai->tanggal_lahir ?? null),
                'Jenis Kelamin' => safe($pegawai->jenis_kelamin ?? null),
                'Golongan Darah' => safe($pegawai->golongan_darah ?? null),
                'Agama' => safe($pegawai->agama ?? null),
                'Status Perkawinan' => safe($pegawai->status_perkawinan ?? null),
                'NIK' => safe($pegawai->nik ?? null),
                'Nomor HP' => safe($pegawai->nomor_hp ?? null),
                'Email' => safe($pegawai->email ?? null),
                'Alamat' => safe($pegawai->alamat ?? null),
                'NPWP' => $isPppk ? safe($pegawai->npwp_nomor ?? null) : safe($pegawai->npwp ?? null),
              ],

              'Data Kepegawaian' => [
                'BPJS' => safe($pegawai->bpjs ?? null),
                'Jenis' => safe($pegawai->jenis ?? null),
                'Jenis Pegawai' => $tipe,
                'Kedudukan Hukum' => safe($pegawai->kedudukan_hukum_nama ?? $pegawai->kedudukan_hukum ?? null),
                'Status CPNS/PNS' => safe($pegawai->status_cpns_pns ?? null),
                'Kartu ASN Virtual' => safe($pegawai->kartu_asn_virtual ?? null),
                'Nomor SK CPNS' => safe($pegawai->nomor_sk_cpns ?? null),
                'TMT CPNS' => safe($pegawai->tmt_cpns ?? null),
                'Nomor SK PNS' => safe($pegawai->nomor_sk_pns ?? null),
                'TMT PNS' => safe($pegawai->tmt_pns ?? null),
                'Golongan Awal' => $isPppk ? safe($pegawai->gol_awal ?? null) : safe($pegawai->gol_awal_nama ?? null),
                'Golongan Akhir' => $isPppk ? safe($pegawai->gol_akhir ?? null) : safe($pegawai->gol_akhir_nama ?? null),
                'TMT Golongan' => safe($pegawai->tmt_golongan ?? null),
                'Masa Kerja (Tahun)' => safe($pegawai->mk_tahun ?? null),
                'Masa Kerja (Bulan)' => safe($pegawai->mk_bulan ?? null),
                'Jenis Jabatan' => safe($pegawai->jenis_jabatan ?? null),
                'Eselon' => safe($pegawai->eselon ?? null),
                'Jabatan' => safe($pegawai->jabatan ?? null),
                'Kategori' => safe($pegawai->kategori ?? null),
                'Rumpun Jabatan' => safe($pegawai->rumpun_jabatan ?? null),
                'TMT Jabatan' => safe($pegawai->tmt_jabatan ?? null),
              ],

              'Pendidikan & Diklat' => [
                'Riwayat Diklat' => safe($pegawai->riwayat_diklat ?? null),
                'Tingkat Pendidikan' => safe($pegawai->tingkat_pendidikan_nama ?? null),
                'Jurusan Pendidikan' => $isPppk ? safe($pegawai->pendidikan ?? null) : safe($pegawai->pendidikan_nama ?? null),
                'Tahun Lulus' => safe($pegawai->tahun_lulus ?? null),
              ],

              'Unit Organisasi' => [
                'Unit Organisasi' => safe($pegawai->unor ?? null),
                'Instansi Induk' => safe($pegawai->instansi_induk ?? null),
                'Instansi Kerja' => safe($pegawai->instansi_kerja ?? null),
                'Satker Induk' => safe($pegawai->satuan_kerja_induk ?? null),
                'Satker Kerja' => safe($pegawai->satuan_kerja_kerja ?? null),
              ],

              'Identitas Pegawai' => [
                'Tipe Pegawai' => $tipe,
              ],
            ];
          @endphp

          {{-- LOOP TIAP SECTION --}}
          @foreach ($sections as $title => $fields)
            <div class="space-y-4">
              <h3 class="text-lg font-semibold text-blue-700 border-b pb-2">{{ $title }}</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($fields as $label => $value)
                  <div class="border p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                    <p class="text-xs text-gray-500">{{ $label }}</p>
                    <p class="{{ $value && $value !== '-' ? 'font-semibold text-gray-800' : 'text-empty' }}">
                      {{ $value }}
                    </p>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </main>
  </div>

  {{-- Script animasi & logout --}}
  <script>
    // Efek animasi masuk
    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });

    // Konfirmasi logout
    const logoutBtn = document.getElementById("logout-btn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", () => {
        Swal.fire({
          title: "Yakin ingin logout?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, logout",
          cancelButtonText: "Batal"
        }).then(result => {
          if (result.isConfirmed) {
            document.getElementById("logout-form").submit();
          }
        });
      });
    }
  </script>

</body>
</html>
