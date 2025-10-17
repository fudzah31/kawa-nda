{{-- resources/views/admin/pesan/partials/update_profil.blade.php --}}
<div class="space-y-8">

  {{-- Data Pegawai --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Data Pegawai</h3>
    <div class="overflow-hidden rounded-xl border">
      <table class="w-full text-sm text-gray-700">
        <tbody class="divide-y divide-gray-200">
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium w-48 text-gray-600">Nama Lengkap</th>
            <td class="px-4 py-2">{{ $data->nama_lengkap ?? '-' }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">NIP</th>
            <td class="px-4 py-2">{{ $data->nip ?? '-' }}</td>
          </tr>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 font-medium text-gray-600">Jenis Pegawai</th>
            <td class="px-4 py-2">{{ $data->jenis_pegawai ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- Data yang Diajukan untuk Diperbarui --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Data yang Diajukan untuk Diperbarui</h3>
    @php
      $fieldDiajukan = $data->field_diperbarui ?? null;

      // Jika berupa string JSON
      if (is_string($fieldDiajukan) && str_starts_with(trim($fieldDiajukan), '[')) {
          $decoded = json_decode($fieldDiajukan, true);
          if (json_last_error() === JSON_ERROR_NONE) {
              $fieldDiajukan = $decoded;
          }
      }

      // Jika berupa daftar dipisah koma
      if (is_string($fieldDiajukan) && str_contains($fieldDiajukan, ',')) {
          $fieldDiajukan = array_map('trim', explode(',', $fieldDiajukan));
      }
    @endphp

    @if(!empty($fieldDiajukan))
      <div class="text-blue-600 text-base font-semibold leading-relaxed">
        @if(is_array($fieldDiajukan))
          @foreach($fieldDiajukan as $f)
            <span class="block">{{ strtoupper($f) }}</span>
          @endforeach
        @else
          <span class="block">{{ strtoupper($fieldDiajukan) }}</span>
        @endif
      </div>
    @else
      <p class="text-gray-500">Tidak ada data yang diajukan untuk diperbarui.</p>
    @endif
  </div>

  {{-- Alasan Pengajuan --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Alasan Pengajuan</h3>
    <p class="text-gray-700 whitespace-pre-line">
      {{ $data->alasan ?? 'Tidak ada alasan yang diberikan.' }}
    </p>
  </div>

  {{-- Dokumen Pendukung --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-lg font-semibold mb-4">Dokumen Pendukung</h3>
    <ul class="space-y-3 text-sm">
      <li>
        <span class="font-medium">Dokumen 1:</span>
        @if(!empty($data->dokumen_1))
          <a href="{{ asset('storage/' . $data->dokumen_1) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
            📄 Lihat Dokumen 1
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>

      <li>
        <span class="font-medium">Dokumen 2:</span>
        @if(!empty($data->dokumen_2))
          <a href="{{ asset('storage/' . $data->dokumen_2) }}" target="_blank"
             class="ml-2 inline-block px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
            📄 Lihat Dokumen 2
          </a>
        @else
          <span class="ml-2 text-gray-500">Tidak ada</span>
        @endif
      </li>
    </ul>
  </div>

  {{-- Aksi --}}
  <div class="bg-white p-6 rounded-2xl shadow-md border flex justify-between items-center">
    <a href="{{ route('admin.pesan.index') }}"
       class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
       ← Kembali
    </a>

    <form action="{{ route('admin.pesan.update', $data->id) }}" method="POST" class="flex items-center gap-3">
      @csrf
      @method('PUT')
      <input type="hidden" name="tipe" value="update_profil">
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
