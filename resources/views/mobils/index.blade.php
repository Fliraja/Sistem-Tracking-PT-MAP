<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Daftar Mobil</h2>
            <a href="{{ route('mobils.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Tambah Mobil
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Plat</th>
                    <th class="px-4 py-2 border">Jenis</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mobils as $mobil)
                    <tr class="border-t">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $mobil->plat }}</td>
                        <td class="px-4 py-2 border">{{ $mobil->jenis }}</td>
                        <td class="px-4 py-2 border text-center">
                            <a href="{{ route('mobils.edit', $mobil->id) }}"
                                class="text-yellow-600 hover:underline">Edit</a>
                            |
                            <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">Belum ada data mobil</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $mobils->links() }}
        </div>
    </div>
</x-app-layout>
