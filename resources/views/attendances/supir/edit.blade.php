<x-app-layout>

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold mb-4">Detail Tugas Pengiriman</h1>

        <form action="{{ route('supir.attendances.update', $attendance->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Nomor Plat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nomor Plat</label>
                <select disabled name="mobil_id" class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500">
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}" {{ $attendance->mobil_id == $mobil->id ? 'selected' : '' }}>
                            {{ $mobil->plat }} - {{ $mobil->jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Pengemudi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nama Pengemudi</label>
                <select disabled name="user_id" class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" required>
                    <option value="" disabled selected>-- Pilih Pengemudi --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $attendance->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Supplier -->
                <div>
                    <label class="block text-gray-700 font-medium">Supplier</label>
                    <input disabled type="text" name="supplier" id="supplier"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->supplier }}"
                        readonly>
                </div>

                <!-- Tujuan -->
                <div>
                    <label class="block text-gray-700 font-medium">Tujuan</label>
                    <input disabled type="text" name="tujuan" id="tujuan"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->tujuan }}"
                        readonly>
                </div>
            </div>

            <!-- Ukuran -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Panjang (cm)</label>
                    <input disabled type="number" name="panjang" id="panjang"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->panjang }}"
                        readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Lebar (cm)</label>
                    <input disabled type="number" name="lebar" id="lebar"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->lebar }}"
                        readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Tinggi (cm)</label>
                    <input disabled type="number" name="tinggi" id="tinggi"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->tinggi }}"
                        readonly>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Plus (cm)</label>
                    <input disabled type="number" name="plus" id="plus"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->plus }}"
                        readonly>
                </div>
                <!-- Volume otomatis -->
                <div>
                    <label class="block text-gray-700 font-medium">Volume (m³)</label>
                    <input disabled type="number" step="0.01" name="volume" id="volume"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500" value="{{ $attendance->volume }}"
                        readonly>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Status</label>
                <select disabled name="status" class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100 cursor-not-allowed text-gray-500">
                    <option value="proses" {{ $attendance->status == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="perjalanan" {{ $attendance->status == 'perjalanan' ? 'selected' : '' }}>Perjalanan
                    </option>
                    <option value="selesai" {{ $attendance->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Tanggal dan Jam -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Tanggal & Jam Keberangkatan</label>
                <input type="datetime-local" name="tanggal_berangkat" id="tanggal_berangkat"
                    class="w-full border-gray-300 rounded-lg mt-1
        {{ in_array($attendance->status, ['perjalanan', 'selesai'])
            ? 'bg-gray-100 cursor-not-allowed text-gray-500'
            : 'bg-white' }}"
                    value="{{ $attendance->tanggal_berangkat
                        ? \Carbon\Carbon::parse($attendance->tanggal_berangkat)->format('Y-m-d\TH:i')
                        : '' }}"
                    {{ in_array($attendance->status, ['perjalanan', 'selesai']) ? 'disabled' : '' }} required>

            </div>

            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <label for="foto_berangkat">Foto Berangkat</label>
                    <input type="file" name="foto_berangkat" id="foto_berangkat" class="form-control"
                        accept="image/*"
                        {{ in_array($attendance->status, ['perjalanan', 'selesai']) ? 'disabled' : 'required' }}>
                    @if ($attendance->foto_berangkat)
                        <img src="{{ asset('storage/' . $attendance->foto_berangkat) }}" class="mt-2 rounded-lg w-32">
                    @endif
                </div>
                @if ($attendance->status === 'proses')
                @else
                    <div>
                        <label for="foto_sampai">Foto Sampai</label>
                        <input type="file" name="foto_sampai" id="foto_sampai" class="form-control" accept="image/*"
                            {{ in_array($attendance->status, ['selesai']) ? 'disabled' : 'required' }}>
                        @if ($attendance->foto_sampai)
                            <img src="{{ asset('storage/' . $attendance->foto_sampai) }}" class="mt-2 rounded-lg w-32">
                        @endif
                    </div>
                @endif
            </div>

            <!-- Tombol Submit -->
            @if ($attendance->status === 'proses')
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Mulai Perjalanan
                    </button>
                </div>
            @elseif ($attendance->status === 'perjalanan')
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Selesaikan Pengiriman
                    </button>
                </div>
            @else
                <div class="flex justify-end">
                    <div class="text-center text-green-600 font-semibold">
                        ✅ Pengiriman telah selesai
                    </div>
                </div>
            @endif
        </form>
    </div>

    <script>
        // Hitung volume otomatis
        document.querySelectorAll('#panjang, #lebar, #tinggi').forEach(input => {
            input.addEventListener('input', () => {
                const p = parseFloat(document.getElementById('panjang').value) || 0;
                const l = parseFloat(document.getElementById('lebar').value) || 0;
                const t = parseFloat(document.getElementById('tinggi').value) || 0;

                const volume = (p * l * t) / 1000000;
                document.getElementById('volume').value = volume.toFixed(2);
            });
        });
    </script>
</x-app-layout>
