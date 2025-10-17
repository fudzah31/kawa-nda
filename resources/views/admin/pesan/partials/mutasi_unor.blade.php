{{-- resources/views/admin/pesan/partials/mutasi_unor.blade.php --}}
<div class="space-y-8">

  {{-- 🧍‍♂️ Data Pegawai --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5.121 17.804A9.004 9.004 0 0112 15c2.21 0 4.21.804 5.879 2.121M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      Data Pegawai
    </h3>

    <div class="overflow-hidden rounded-xl border">
      <table class="w-full text-sm text-gray-700">
        <tbody class="divide-y divide-gray-200">
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium w-48 text-gray-600">Nama</th>
            <td class="px-4 py-2">{{ $data->nama ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">NIP</th>
            <td class="px-4 py-2">{{ $data->nip ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">Pangkat / Golongan</th>
            <td class="px-4 py-2">{{ $data->gol_akhir_nama ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">Jabatan</th>
            <td class="px-4 py-2">{{ $data->jabatan ?? $data->jabatan_nama ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">Unit Asal</th>
            <td class="px-4 py-2">{{ $data->unor ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">Unit Tujuan</th>
            <td class="px-4 py-2">{{ $data->unor_tujuan ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">TMT Jabatan Baru</th>
            <td class="px-4 py-2">
              {{ $data->tmt_jabatan_baru ? \Carbon\Carbon::parse($data->tmt_jabatan_baru)->format('d-m-Y') : '-' }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- 📄 Bukti Dukung --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m-6-8h6M5 8h.01M5 12h.01M5 16h.01M19 8h.01M19 12h.01M19 16h.01" />
      </svg>
      Bukti Dukung
    </h3>

    <ul class="space-y-3 text-sm">
      <li>
        <span class="font-medium">SK Mutasi:</span>
        @if(!empty($data->sk_mutasi))
          <a href="{{ asset('storage/'.$data->sk_mutasi) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
             📄 Lihat Dokumen
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">SK Pelantikan:</span>
        @if(!empty($data->sk_pelantikan))
          <a href="{{ asset('storage/'.$data->sk_pelantikan) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
             📄 Lihat Dokumen
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">Berita Acara Pelantikan:</span>
        @if(!empty($data->berita_acara_pelantikan))
          <a href="{{ asset('storage/'.$data->berita_acara_pelantikan) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
             📄 Lihat Dokumen
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">SK Jabatan:</span>
        @if(!empty($data->sk_jabatan))
          <a href="{{ asset('storage/'.$data->sk_jabatan) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
             📄 Lihat Dokumen
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">SPMT OPD Baru:</span>
        @if(!empty($data->spmt))
          <a href="{{ asset('storage/'.$data->spmt) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
             📄 Lihat Dokumen
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>
    </ul>
  </div>

  {{-- ⚙️ Aksi --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border flex justify-between items-center">
    <a href="{{ route('admin.pesan.index') }}"
       class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
       ← Kembali
    </a>

    <form action="{{ route('admin.pesan.update', $data->id) }}" method="POST" class="flex items-center gap-3">
      @csrf
      @method('PUT')
      <input type="hidden" name="tipe" value="mutasi_unor">
      <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="pending" {{ strtolower($data->status) == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
        <option value="selesai" {{ strtolower($data->status) == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
        <option value="ditolak" {{ strtolower($data->status) == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
      </select>

      <button type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Update
      </button>
    </form>
  </div>

</div>
