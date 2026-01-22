<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-semibold mb-4">Detail Users</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <table class="w-full text-sm">
                <tr>
                    <td class="py-2 font-semibold">Nama</td>
                    <td class="py-2">{{ $users->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Email</td>
                    <td class="py-2">{{ $users->email }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Alamat</td>
                    <td class="py-2">{{ $users->alamat }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">No. Hp</td>
                    <td class="py-2">{{ $users->no_hp }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Role</td>
                    <td class="py-2">{{ ucfirst($users->role) }}</td>
                </tr>
            </table>
            <div class="mt-1">
                <strong class="py-2 font-semibold">Foto SIM</strong>
                @if ($users->foto_sim)
                    <img width="300" height="450" src="{{ asset('storage/' . $users->foto_sim) }}"
                        class="mt-2 rounded-lg max-w-full h-auto">
                @else
                    <br>
                    <strong class="py-2 font-semibold">Tidak ada foto SIM</strong>
                @endif
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                Kembali
            </a>

            <h5 class="text-sm text-gray-500">
                Terakhir di update : {{ $users->updated_at->format('d M Y H:i') }}
            </h5>
        </div>
    </div>
</x-app-layout>
