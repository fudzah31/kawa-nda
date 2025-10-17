{{-- resources/views/user/layanan/update-profil.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Profil - Kawa-Nda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .text-shadow { text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
    .sidebar-link { transition: all 0.3s ease; }
    .sidebar-link:hover { transform: translateX(6px); background: linear-gradient(to right, #2563eb, #facc15); color: white; }
    .fade-slide { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .fade-slide.show { opacity: 1; transform: translateY(0); }
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
            <a href="{{ route('user.dashboard') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              <span>🏠</span> Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('user.profile.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg">
              <span>👤</span> Profil Saya
            </a>
          </li>
          <li>
            <a href="{{ route('user.layanan.index') }}" class="sidebar-link flex items-center gap-2 px-5 py-3 rounded-lg bg-blue-600 text-white">
              <span>📂</span> Update Data Kepegawaian
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
      <h2 class="text-2xl font-bold text-gray-700">UPDATE PROFIL PEGAWAI</h2>
      <p class="text-gray-600">Silakan pilih field yang ingin diperbarui, isi alasan, dan unggah dokumen pendukung.</p>

      {{-- Pesan Sukses/Error --}}
      @if(session('success'))
        <div id="flash-success" class="hidden" data-message="{{ session('success') }}"></div>
      @endif
      @if(session('error'))
        <div id="flash-error" class="hidden" data-message="{{ session('error') }}"></div>
      @endif

      @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- FORM UPDATE PROFIL --}}
      <form action="{{ route('user.layanan.update-profil.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- Identitas dasar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ $pegawai->nama ?? Auth::user()->name }}" readonly
                   class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
          <div>
            <label class="block font-medium mb-1">NIP</label>
            <input type="text" name="nip" value="{{ $pegawai->nip ?? '' }}" readonly
                   class="w-full border rounded-lg p-2 bg-gray-100">
          </div>
        </div>

        {{-- Hidden tambahan --}}
        <input type="hidden" name="jenis_pegawai" value="{{ ($pegawai instanceof \App\Models\Pns) ? 'PNS' : (($pegawai instanceof \App\Models\Pppk) ? 'PPPK' : '') }}">

        {{-- Pilihan field --}}
        <div>
          <label class="block font-semibold mb-1 text-gray-700">Pilih Field yang Ingin Diperbarui</label>
          @php
            $jenisPegawai = ($pegawai instanceof \App\Models\Pns) ? 'pns' : (($pegawai instanceof \App\Models\Pppk) ? 'pppk' : null);

            $fieldsPns = [
              'nama' => 'Nama Lengkap', 'gelar_depan' => 'Gelar Depan', 'gelar_belakang' => 'Gelar Belakang',
              'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'jenis_kelamin' => 'Jenis Kelamin',
              'golongan_darah' => 'Golongan Darah', 'agama' => 'Agama', 'status_perkawinan' => 'Status Perkawinan',
              'nik' => 'NIK', 'nomor_hp' => 'Nomor HP', 'email' => 'Email', 'alamat' => 'Alamat', 'npwp' => 'NPWP',
              'bpjs' => 'BPJS', 'jabatan' => 'Jabatan', 'unor' => 'Unit Organisasi', 'instansi_kerja' => 'Instansi Kerja',
              'pendidikan_nama' => 'Pendidikan', 'tahun_lulus' => 'Tahun Lulus'
            ];

            $fieldsPppk = [
              'nama' => 'Nama Lengkap', 'gelar_depan' => 'Gelar Depan', 'gelar_belakang' => 'Gelar Belakang',
              'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'jenis_kelamin' => 'Jenis Kelamin',
              'golongan_darah' => 'Golongan Darah', 'agama' => 'Agama', 'status_perkawinan' => 'Status Perkawinan',
              'nik' => 'NIK', 'nomor_hp' => 'Nomor HP', 'email' => 'Email', 'alamat' => 'Alamat',
              'jabatan' => 'Jabatan', 'unor' => 'Unit Organisasi', 'instansi_kerja' => 'Instansi Kerja',
              'pendidikan' => 'Pendidikan', 'tahun_lulus' => 'Tahun Lulus'
            ];

            $fieldOptions = ($jenisPegawai == 'pns') ? $fieldsPns : (($jenisPegawai == 'pppk') ? $fieldsPppk : []);
          @endphp

          <select id="fieldSelect" name="field_diperbarui" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
            <option value="">-- Pilih Field --</option>
            @foreach($fieldOptions as $key => $label)
              <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
          </select>

          <p class="text-xs text-gray-500 mt-1">Jenis pegawai: <span class="font-semibold uppercase">{{ $jenisPegawai ?? '-' }}</span></p>
        </div>

        {{-- Alasan Update --}}
        <div id="alasanWrapper" class="hidden">
          <label class="block font-semibold mb-1 text-gray-700">Alasan Update</label>
          <textarea name="alasan" rows="4" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300"
            placeholder="Tuliskan alasan pengajuan..."></textarea>
        </div>

        {{-- Dokumen pendukung --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Dokumen Pendukung 1 (Wajib)</label>
            <input type="file" name="dokumen_1" accept=".pdf,image/*"
                   class="w-full border rounded-lg p-2 bg-gray-50" required>
          </div>
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Dokumen Pendukung 2 (Opsional)</label>
            <input type="file" name="dokumen_2" accept=".pdf,image/*"
                   class="w-full border rounded-lg p-2 bg-gray-50">
            <p class="text-xs text-gray-500 mt-1">Format: PDF/JPG/PNG, maks 4MB.</p>
          </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex justify-end gap-4">
          <button type="reset" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">Reset</button>
          <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
            Ajukan
          </button>
        </div>
      </form>
    </main>
  </div>

  {{-- Script Animasi & Alert --}}
  <script>
    // Animasi fade-slide
    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".fade-slide").forEach(el => {
        setTimeout(() => el.classList.add("show"), 200);
      });
    });

    // Logout dengan SweetAlert
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

    // Tampilkan alasan jika field dipilih
    const fieldSelect = document.getElementById('fieldSelect');
    const alasanWrapper = document.getElementById('alasanWrapper');
    if (fieldSelect) {
      fieldSelect.addEventListener('change', function() {
        if (this.value) alasanWrapper.classList.remove('hidden');
        else alasanWrapper.classList.add('hidden');
      });
    }

    // SweetAlert pesan sukses/error dari session
    const flashSuccess = document.getElementById('flash-success');
    const flashError = document.getElementById('flash-error');

    if (flashSuccess) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: flashSuccess.dataset.message,
        timer: 3000,
        showConfirmButton: false
      });
    }

    if (flashError) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: flashError.dataset.message,
        timer: 3500,
        showConfirmButton: false
      });
    }
  </script>
</body>
</html>
