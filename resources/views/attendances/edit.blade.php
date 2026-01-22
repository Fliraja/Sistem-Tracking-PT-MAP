<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold mb-4">Edit Data Attendance</h1>

        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nomor Plat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nomor Plat</label>
                <select name="mobil_id" class="w-full border-gray-300 rounded-lg mt-1">
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
                <select name="user_id" class="w-full border-gray-300 rounded-lg mt-1" required>
                    <option value="" disabled selected>-- Pilih Pengemudi --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $attendance->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal dan Jam -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Tanggal & Jam Keberangkatan</label>
                <input type="datetime-local" name="tanggal_berangkat" id="tanggal_berangkat"
                    class="w-full border-gray-300 rounded-lg mt-1"
                    value="{{ $attendance->tanggal_berangkat
                        ? \Carbon\Carbon::parse($attendance->tanggal_berangkat)->format('Y-m-d\TH:i')
                        : '' }}">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Supplier -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->supplier }}">
                </div>

                <!-- Tujuan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->tujuan }}">
                </div>
            </div>

            <!-- Ukuran -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Panjang (cm)</label>
                    <input type="number" name="panjang" id="panjang" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->panjang }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Lebar (cm)</label>
                    <input type="number" name="lebar" id="lebar" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->lebar }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Tinggi (cm)</label>
                    <input type="number" name="tinggi" id="tinggi" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->tinggi }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Plus (cm)</label>
                    <input type="number" name="plus" id="plus" class="w-full border-gray-300 rounded-lg mt-1"
                        value="{{ $attendance->plus }}">
                </div>
                <!-- Volume otomatis -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Volume (m³)</label>
                    <input type="number" step="0.01" name="volume" id="volume"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100" value="{{ $attendance->volume }}"
                        readonly>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg mt-1">
                    <option value="proses" {{ $attendance->status == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="perjalanan" {{ $attendance->status == 'perjalanan' ? 'selected' : '' }}>Perjalanan
                    </option>
                    <option value="selesai" {{ $attendance->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <label for="foto_berangkat">Foto Berangkat</label>
                    <input type="file" name="foto_berangkat" id="foto_berangkat" class="form-control"
                        accept="image/*">
                    @if ($attendance->foto_berangkat)
                        <img src="{{ asset('storage/' . $attendance->foto_berangkat) }}" class="mt-2 rounded-lg w-32">
                    @endif
                </div>

                <div>
                    <label for="foto_sampai">Foto Sampai</label>
                    <input type="file" name="foto_sampai" id="foto_sampai" class="form-control" accept="image/*">
                    @if ($attendance->foto_sampai)
                        <img src="{{ asset('storage/' . $attendance->foto_sampai) }}" class="mt-2 rounded-lg w-32">
                    @endif
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>
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
