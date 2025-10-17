<!-- Pegawai Card Component -->
<div class="bg-white p-6 rounded-2xl shadow flex justify-between items-center transition transform hover:scale-[1.02] hover:shadow-lg">
  <div>
    <p class="text-lg font-bold text-gray-800">{{ $pegawai->nama ?? '-' }}</p>
    <p class="text-sm {{ empty($pegawai->nip) ? 'text-red-500 italic' : 'text-gray-600' }}">NIP: {{ $pegawai->nip ?? '-' }}</p>
    <p class="text-sm {{ empty($pegawai->jabatan) ? 'text-red-500 italic' : 'text-gray-600' }}">Jabatan: {{ $pegawai->jabatan ?? '-' }}</p>
  </div>
  <div class="text-right">
    <p class="text-xs text-gray-500">Status</p>
    <p class="font-bold {{ ($pegawai->kedudukan_hukum_nama ?? 'Aktif') === 'Aktif' ? 'text-green-600' : 'text-red-600' }}">
      {{ $pegawai->kedudukan_hukum_nama ?? 'Aktif' }}
    </p>
  </div>
</div>
