{{-- resources/views/admin/pesan/partials/kenaikan_pangkat.blade.php --}}
<div class="space-y-8">

  {{-- 🧍‍♂️ Data Pegawai --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Data Pegawai</h3>
    <div class="overflow-hidden rounded-xl border">
      <table class="w-full text-sm text-gray-700">
        <tbody class="divide-y divide-gray-200">
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium w-48 text-gray-600">Nama Lengkap</th>
            <td class="px-4 py-2">{{ $data->nama ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">NIP</th>
            <td class="px-4 py-2">{{ $data->nip ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">Jabatan</th>
            <td class="px-4 py-2">{{ $data->jabatan ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">Pangkat / Golongan</th>
            <td class="px-4 py-2">{{ $data->pangkat ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">Unit Organisasi</th>
            <td class="px-4 py-2">{{ $data->unor ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- 📄 Dokumen Pendukung --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Dokumen Pendukung</h3>
    <ul class="space-y-3 text-sm">
      <li>
        <span class="font-medium">SK Pangkat Terakhir:</span>
        @if(!empty($data->sk_pangkat))
          <a href="{{ asset('storage/' . $data->sk_pangkat) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
            📄 Lihat SK Pangkat
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">SPMT:</span>
        @if(!empty($data->spmt))
          <a href="{{ asset('storage/' . $data->spmt) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
            📄 Lihat SPMT
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
       class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
       ← Kembali
    </a>

    <form action="{{ route('admin.pesan.update', $data->id) }}" method="POST" class="flex items-center gap-3">
      @csrf
      @method('PUT')
      <input type="hidden" name="tipe" value="kenaikan_pangkat">
      <select name="status" class="border rounded px-3 py-2">
        <option value="pending" {{ strtolower($data->status) == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
        <option value="selesai" {{ strtolower($data->status) == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
        <option value="ditolak" {{ strtolower($data->status) == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
      </select>

      <button type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Update
      </button>
    </form>
  </div>

</div>
