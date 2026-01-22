<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold">Daftar Absensi</h2>
            <a href="{{ route('attendances.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Absensi
            </a>
            <a href="{{ route('attendances.export.pdf', request()->all()) }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Export PDF
            </a>
        </div>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 relative">
            {{-- Tombol Export PDF di kanan atas --}}
            {{-- <a href="{{ route('attendances.export.pdf', request()->all()) }}"
                class="absolute right-0 top-0 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Export PDF
            </a> --}}

            {{-- FORM FILTER --}}
            <form id="filterForm" action="{{ route('attendances.index') }}" method="GET"
                class="flex flex-wrap gap-4 items-end">
                {{-- Dropdown jenis filter --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Filter Berdasarkan</label>
                    <select id="filter_type" name="filter_type" class="border-gray-300 rounded-lg">
                        <option value="">-- Pilih Filter --</option>
                        <option value="harian" {{ request('filter_type') == 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="bulanan" {{ request('filter_type') == 'bulanan' ? 'selected' : '' }}>Bulanan
                        </option>
                        <option value="mobil" {{ request('filter_type') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="supplier" {{ request('filter_type') == 'supplier' ? 'selected' : '' }}>Supplier
                        </option>
                    </select>
                </div>

                {{-- Tempat field filter dinamis --}}
                <div id="filter_fields" class="flex gap-4 items-end"></div>

                {{-- Tombol Terapkan --}}
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto">
            @include('attendances.partials.table', ['attendances' => $attendances])
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterType = document.getElementById('filter_type');
            const filterFields = document.getElementById('filter_fields');

            // data untuk populasi mobil dari server
            const mobils = @json($mobils);

            function renderFilterFields() {
                const type = filterType.value;
                filterFields.innerHTML = ''; // kosongkan dulu

                if (type === 'harian') {
                    filterFields.innerHTML = `
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Tanggal</label>
                            <input type="date" name="date" value="{{ request('date') }}" class="border-gray-300 rounded-lg">
                        </div>
                    `;
                } else if (type === 'bulanan') {
                    filterFields.innerHTML = `
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Bulan</label>
                            <input type="month" name="month" value="{{ request('month') }}" class="border-gray-300 rounded-lg">
                        </div>
                    `;
                } else if (type === 'mobil') {
                    let options = mobils.map(m =>
                        `<option value="${m.id}" {{ request('mobil_id') == '${m.id}' ? 'selected' : '' }}>${m.plat} - ${m.jenis}</option>`
                    ).join('');

                    filterFields.innerHTML = `
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Mobil</label>
                            <select name="mobil_id" class="border-gray-300 rounded-lg">${options}</select>
                        </div>
                    `;
                } else if (type === 'supplier') {
                    filterFields.innerHTML = `
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Supplier</label>
                            <input type="text" name="supplier" value="{{ request('supplier') }}" class="border-gray-300 rounded-lg">
                        </div>
                    `;
                }
            }

            // render form saat pertama kali (misal dari reload)
            renderFilterFields();

            // render ulang jika dropdown berubah
            filterType.addEventListener('change', renderFilterFields);
        });
    </script>
</x-app-layout>
