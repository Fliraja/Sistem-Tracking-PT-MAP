<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-xl font-semibold mb-4">Tambah Data Mobil</h2>

        {{-- @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('mobils.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="plat" class="block font-medium mb-1">Nomor Plat</label>
                <input type="text" name="plat" id="plat" value="{{ old('plat') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="jenis" class="block font-medium mb-1">Jenis Kendaraan</label>
                <input type="text" name="jenis" id="jenis" value="{{ old('jenis') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('mobils.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
