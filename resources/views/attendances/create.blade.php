<x-app-layout>

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-semibold mb-4">Form Absensi Mobil</h2>

        <form action="{{ route('attendances.store') }}" method="POST" enctype="multipart/form-data" id="attendanceForm">
            @csrf

            <!-- Nomor Plat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nomor Plat</label>
                <select name="mobil_id" class="w-full border-gray-300 rounded-lg mt-1" required>
                    <option value="" disabled selected>-- Pilih Mobil --</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}">{{ $mobil->plat }} - {{ $mobil->jenis }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Pengemudi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nama Pengemudi</label>
                <select name="user_id" class="w-full border-gray-300 rounded-lg mt-1" required>
                    <option value="" disabled selected>-- Pilih Pengemudi --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal dan Jam -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Tanggal & Jam Keberangkatan</label>
                <input type="datetime-local" name="tanggal_berangkat" class="w-full border-gray-300 rounded-lg mt-1">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Supplier -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Supplier</label>
                    <input type="text" name="supplier" class="w-full border-gray-300 rounded-lg mt-1" required>
                </div>

                <!-- Tujuan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Tujuan</label>
                    <input type="text" name="tujuan" class="w-full border-gray-300 rounded-lg mt-1" required>
                </div>
            </div>

            <!-- Ukuran -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Panjang (cm)</label>
                    <input type="number" name="panjang" id="panjang" class="w-full border-gray-300 rounded-lg mt-1">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Lebar (cm)</label>
                    <input type="number" name="lebar" id="lebar" class="w-full border-gray-300 rounded-lg mt-1">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Tinggi (cm)</label>
                    <input type="number" name="tinggi" id="tinggi" class="w-full border-gray-300 rounded-lg mt-1">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium">Plus (cm)</label>
                    <input type="number" name="plus" id="plus" class="w-full border-gray-300 rounded-lg mt-1">
                </div>
                <!-- Volume otomatis -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Volume (m³)</label>
                    <input type="number" step="0.01" name="volume" id="volume"
                        class="w-full border-gray-300 rounded-lg mt-1 bg-gray-100" readonly>
                </div>
            </div>



            <!-- Nomor Plat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg mt-1">
                    <option value="proses" selected>Proses</option>
                    <option value="perjalanan">Perjalanan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <!-- Foto Berangkat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Foto Berangkat</label>
                <input type="file" name="foto_berangkat" accept="image/*"
                    class="w-full mt-1 border-gray-300 rounded-lg">
            </div>

            <!-- Foto Sampai -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Foto Sampai</label>
                <input type="file" name="foto_sampai" accept="image/*"
                    class="w-full mt-1 border-gray-300 rounded-lg">
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Data
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
