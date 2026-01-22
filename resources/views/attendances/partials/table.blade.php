<table class="min-w-full border border-gray-200 text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-3 py-2">No</th>
            <th class="border px-3 py-2">No Plat</th>
            <th class="border px-3 py-2">Nama Sopir</th>
            <th class="border px-3 py-2">Tanggal</th>
            <th class="border px-3 py-2">Supplier</th>
            <th class="border px-3 py-2">Tujuan</th>
            <th class="border px-3 py-2">Volume (m³)</th>
            <th class="border px-3 py-2">Status</th>
            <th class="border px-3 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($attendances as $index => $attendance)
            <tr class="hover:bg-gray-50">
                <td class="border px-3 py-2 text-center">{{ $index + 1 }}</td>
                <td class="border px-3 py-2 text-center">{{ $attendance->mobil->plat }}</td>
                <td class="border px-3 py-2">{{ $attendance->user->name }}</td>
                <td class="border px-3 py-2 text-center">
                    @if ($attendance->tanggal_berangkat)
                        {{ \Carbon\Carbon::parse($attendance->tanggal_berangkat)->format('d-m-Y H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td class="border px-3 py-2">{{ $attendance->supplier }}</td>
                <td class="border px-3 py-2">{{ $attendance->tujuan }}</td>
                <td class="border px-3 py-2 text-center">{{ number_format($attendance->volume, 2) }}</td>
                <td class="border px-3 py-2 text-center">
                    <span
                        class="px-2 py-1 rounded text-white text-xs
                                @if ($attendance->status === 'proses') bg-yellow-500
                                @elseif($attendance->status === 'perjalanan') bg-blue-500
                                @else bg-green-600 @endif">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>
                <td class="border px-3 py-2 text-center">
                    <a href="{{ route('attendances.show', $attendance->id) }}"
                        class="text-blue-600 hover:underline">Detail</a>
                    |
                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                        class="text-yellow-600 hover:underline">Edit</a>
                    |
                    <a href="{{ route('attendances.print', $attendance->id) }}" target="_blank"
                        class="text-green-600 hover:underline">Cetak</a>
                    |
                    <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-3 text-gray-500">Belum ada data absensi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
