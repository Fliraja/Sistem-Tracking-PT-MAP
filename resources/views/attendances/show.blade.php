<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-semibold mb-4">Detail Absensi</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <table class="w-full text-sm">
                <tr>
                    <td class="py-2 font-semibold">No. Plat</td>
                    <td class="py-2">{{ $attendance->mobil->plat }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold w-1/4">Nama</td>
                    <td class="py-2">{{ $attendance->user->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Tanggal Berangkat</td>
                    <td class="py-2">
                        @if ($attendance->tanggal_berangkat)
                            {{ \Carbon\Carbon::parse($attendance->tanggal_berangkat)->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Supplier</td>
                    <td class="py-2">{{ $attendance->supplier }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Tujuan</td>
                    <td class="py-2">{{ $attendance->tujuan }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Panjang</td>
                    <td class="py-2">{{ $attendance->panjang ?? '0' }} cm</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Lebar</td>
                    <td class="py-2">{{ $attendance->lebar ?? '0' }} cm</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Tinggi</td>
                    <td class="py-2">{{ $attendance->tinggi ?? '0' }} cm</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Plus</td>
                    <td class="py-2">{{ $attendance->plus ?? '0' }} cm</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Volume</td>
                    <td class="py-2">{{ $attendance->volume ?? '0' }} m³</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Status</td>
                    <td class="py-2">
                        <span
                            class="px-2 py-1 rounded text-white 
                        @if ($attendance->status == 'proses') bg-yellow-500 
                        @elseif($attendance->status == 'perjalanan') bg-blue-500 
                        @else bg-green-600 @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                </tr>
            </table>
            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <strong>Foto Berangkat:</strong><br>
                    {{-- FOTO BERANGKAT --}}
                    @if ($attendance->foto_berangkat)
                        <img width="300" height="450" src="{{ asset('storage/' . $attendance->foto_berangkat) }}"
                            alt="Foto Berangkat" class="mt-2 rounded-lg shadow-md max-w-full h-auto">
                    @else
                        <div class="text-sm text-gray-600">Belum ada Foto</div>
                    @endif
                </div>

                <div class="mt-1">
                    <strong>Foto Sampai:</strong><br>
                    {{-- FOTO SAMPAI --}}
                    @if ($attendance->foto_sampai)
                        <img width="300" height="450" src="{{ asset('storage/' . $attendance->foto_sampai) }}"
                            alt="Foto Sampai" class="mt-2 rounded-lg shadow-md max-w-full h-auto">
                    @else
                        <div class="text-sm text-gray-600">Belum ada Foto</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('attendances.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                Kembali
            </a>

            <h5 class="text-sm text-gray-500">
                Terakhir di update : {{ $attendance->updated_at }}
            </h5>
        </div>
    </div>
</x-app-layout>
