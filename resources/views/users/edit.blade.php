<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold mb-4">Edit Data Mobil</h1>

        <form id="editForm" action="{{ route('users.update', $mobil->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <label for="name" class="block text-gray-700 font-medium">Nama</label>
                    <input type="text" class="w-full border-gray-300 rounded-lg mt-1" id="name" name="name"
                        value="{{ $mobil->name }}">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    <input type="email" class="w-full border-gray-300 rounded-lg mt-1" id="email" name="email"
                        value="{{ old('email', $mobil->email) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="block text-gray-700 font-medium">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" class="w-full border-gray-300 rounded-lg mt-1 resize-none">{{ old('alamat', $mobil->alamat) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <label for="role" class="block text-gray-700 font-medium">Role</label>
                    <select id="role" name="role"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $mobil->role) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="supir" {{ old('role', $mobil->role) == 'supir' ? 'selected' : '' }}>
                            Supir
                        </option>
                    </select>
                </div>

                <div>
                    <label for="no_hp" class="block text-gray-700 font-medium">No. HP</label>
                    <input type="number" class="w-full border-gray-300 rounded-lg mt-1" id="no_hp" name="no_hp"
                        value="{{ old('no_hp', $mobil->no_hp) }}">
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="new_password" class="block text-gray-700 font-medium">
                    New Password (optional)
                </label>
                <input type="password" name="new_password" id="new_password"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
            </div>
            <input type="hidden" name="password" id="password">

            <div class="mb-3">
                <label for="foto_sim">Foto SIM</label>
                <input type="file" accept="image/*" name="foto_sim" id="foto_sim" class="form-control">
                @if ($mobil->foto_sim)
                    <img src="{{ asset('storage/' . $mobil->foto_sim) }}" class="mt-2 rounded-lg w-32">
                @endif
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
            <a href="{{ route('users.index') }}"
                class="ml-2 text-black px-6 py-2 rounded-lg hover:bg-gray-500">Batal</a>
        </form>
    </div>

    <script>
        document.getElementById('editForm').addEventListener('submit', function(event) {
            const passwordField = document.getElementById('new_password');

            // Jika user mengisi password baru
            if (passwordField.value.trim() !== '') {
                const confirmChange = confirm('Yakin? Password akan diubah.');
                if (!confirmChange) {
                    event.preventDefault(); // batalkan submit
                }
            }
        });
    </script>
</x-app-layout>
