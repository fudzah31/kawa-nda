<div class="bg-white p-6 rounded-2xl shadow fade-slide transition transform hover:scale-[1.01] hover:shadow-lg">
  <h3 class="font-semibold text-gray-700 mb-4">Informasi Kepegawaian</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
    {{-- Golongan / Pangkat --}}
    <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
      <p class="text-xs text-gray-500">Golongan / Pangkat</p>
      <p class="{{ empty($data['golongan_pangkat']) ? 'text-empty' : 'font-semibold' }}">
        {{ $data['golongan_pangkat'] ?? '-' }}
      </p>
    </div>

    {{-- Unit Organisasi --}}
    <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
      <p class="text-xs text-gray-500">Unit Organisasi</p>
      <p class="{{ empty($data['unit_organisasi']) ? 'text-empty' : 'font-semibold' }}">
        {{ $data['unit_organisasi'] ?? '-' }}
      </p>
    </div>

    {{-- Jenis Pegawai (PNS / PPPK) --}}
    <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
      <p class="text-xs text-gray-500">Jenis Pegawai</p>
      <p class="{{ empty($data['jenis_pegawai']) ? 'text-empty' : 'font-semibold' }}">
        {{ $data['jenis_pegawai'] ?? 'PNS/PPPK' }}
      </p>
    </div>

    {{-- Kategori --}}
    <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
      <p class="text-xs text-gray-500">Kategori</p>
      <p class="{{ empty($data['kategori']) ? 'text-empty' : 'font-semibold' }}">
        {{ $data['kategori'] ?? '-' }}
      </p>
    </div>

    {{-- Riwayat Pendidikan --}}
    <div class="p-4 bg-gray-50 rounded-lg shadow-sm md:col-span-2">
      <p class="text-xs text-gray-500">Riwayat Pendidikan</p>
      <p class="{{ empty($data['riwayat_pendidikan']) ? 'text-empty' : 'font-semibold' }}">
        {{ $data['riwayat_pendidikan'] ?? '-' }}
      </p>
    </div>

  </div>
</div>
