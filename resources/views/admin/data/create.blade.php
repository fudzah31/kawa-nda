{{-- resources/views/admin/data/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Pegawai - Kawa-Nda</title>

  {{-- Tailwind + SweetAlert2 --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
              class="block px-4 py-3 rounded-lg bg-gradient-to-r from-sky-600 to-amber-400 text-white font-semibold">
              ➕ Tambah Data
            </a>
          </li>

          {{-- Laporan --}}
          <li>
            <a href="{{ route('admin.laporan.index') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-sky-50">
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
      <h2 class="text-2xl font-bold text-gray-700">Tambah Data Pegawai</h2>
      <p class="text-gray-500">Pilih cara input: upload file atau isi form manual.</p>

      <div class="bg-white p-6 rounded-2xl shadow space-y-6">
        {{-- Notifikasi --}}
        @if(session('success'))
          <script>Swal.fire('Berhasil!', '{{ session('success') }}', 'success');</script>
        @endif
        @if($errors->any())
          <script>Swal.fire('Gagal!', '{{ $errors->first() }}', 'error');</script>
        @endif

        {{-- Pilih Jenis Pegawai --}}
        <div>
          <label for="jenisPegawai" class="block font-semibold mb-2">Jenis Pegawai</label>
          <select id="jenisPegawai" class="border p-2 rounded w-full">
            <option value="pns" selected>PNS</option>
            <option value="pppk">PPPK</option>
          </select>
        </div>

        {{-- Tombol Mode --}}
        <div class="flex gap-4 mb-6">
          <button type="button" id="btnUpload" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Upload File</button>
          <button type="button" id="btnForm" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Input Manual</button>
        </div>

        {{-- Upload PNS --}}
        <div id="uploadSectionPNS" class="hidden">
          <form action="{{ route('admin.data.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="jenis" value="pns">
            <label class="block font-medium">Upload File PNS (Excel, CSV, XLSX)</label>
            <input type="file" name="file" accept=".csv,.xlsx,.xls" class="border rounded w-full p-2" required>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Upload PNS</button>
          </form>
        </div>

        {{-- Form PNS --}}
        <div id="formSectionPNS" class="hidden">
          <form action="{{ route('admin.data.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="jenis" value="pns">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @include('admin.data.partials.form-fields-pns')
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan Data PNS</button>
          </form>
        </div>

        {{-- Upload PPPK --}}
        <div id="uploadSectionPPPK" class="hidden">
          <form action="{{ route('admin.data.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="jenis" value="pppk">
            <label class="block font-medium">Upload File PPPK (Excel, CSV, XLSX)</label>
            <input type="file" name="file" accept=".csv,.xlsx,.xls" class="border rounded w-full p-2" required>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Upload PPPK</button>
          </form>
        </div>

        {{-- Form PPPK --}}
        <div id="formSectionPPPK" class="hidden">
          <form action="{{ route('admin.data.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="jenis" value="pppk">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @include('admin.data.partials.form-fields-pppk')
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan Data PPPK</button>
          </form>
        </div>
      </div>
    </main>
  </div>

  {{-- SCRIPT --}}
  <script>
    // Toggle Upload/Form
    const btnUpload = document.getElementById('btnUpload');
    const btnForm = document.getElementById('btnForm');
    const jenisPegawai = document.getElementById('jenisPegawai');
    const uploadPNS = document.getElementById('uploadSectionPNS');
    const formPNS = document.getElementById('formSectionPNS');
    const uploadPPPK = document.getElementById('uploadSectionPPPK');
    const formPPPK = document.getElementById('formSectionPPPK');
    let currentMode = "upload";

    btnUpload.addEventListener('click', () => { currentMode = "upload"; toggleSections(); });
    btnForm.addEventListener('click', () => { currentMode = "form"; toggleSections(); });
    jenisPegawai.addEventListener('change', () => toggleSections());

    function toggleSections() {
      uploadPNS.classList.add('hidden');
      formPNS.classList.add('hidden');
      uploadPPPK.classList.add('hidden');
      formPPPK.classList.add('hidden');
      const jenis = jenisPegawai.value;
      if (jenis === "pns" && currentMode === "upload") uploadPNS.classList.remove('hidden');
      if (jenis === "pns" && currentMode === "form") formPNS.classList.remove('hidden');
      if (jenis === "pppk" && currentMode === "upload") uploadPPPK.classList.remove('hidden');
      if (jenis === "pppk" && currentMode === "form") formPPPK.classList.remove('hidden');
    }
    toggleSections();

    // Logout Confirm
    document.getElementById('logout-btn').addEventListener('click', () => {
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: 'Sesi Anda akan berakhir.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
      }).then(res => { if (res.isConfirmed) document.getElementById('logout-form').submit(); });
    });

    // Dropdown menu Data
    const dropdownBtn = document.getElementById('dataDropdownBtn');
    const dropdown = document.getElementById('dataDropdown');
    const dropdownIcon = document.getElementById('dataDropdownIcon');
    dropdownBtn.addEventListener('click', () => {
      dropdown.classList.toggle('open');
      dropdownIcon.classList.toggle('rotate-180');
    });
  </script>
</body>
</html>
