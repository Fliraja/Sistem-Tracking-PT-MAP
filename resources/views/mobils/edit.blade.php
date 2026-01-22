<x-app-layout>
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold mb-4">Edit Data Mobil</h1>

    <form action="{{ route('mobils.update', $mobil->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="plat" class="block text-gray-700 font-medium">Nomor Plat</label>
            <input type="text" class="w-full border-gray-300 rounded-lg mt-1" id="plat" name="plat" 
                value="{{ $mobil->plat }}">
        </div>

        <div class="mb-3">
            <label for="jenis" class="block text-gray-700 font-medium">Jenis Mobil</label>
            <input type="text" class="w-full border-gray-300 rounded-lg mt-1" id="jenis" name="jenis" 
                value="{{ old('jenis', $mobil->jenis) }}" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
        <a href="{{ route('mobils.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</x-app-layout>