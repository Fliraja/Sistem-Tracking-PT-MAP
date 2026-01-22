<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background: #e5e5e5;
        }

        h1 {
            text-align: center;
            margin-bottom: 3px;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        p {
            text-align: center;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <h1>PT. MANGGALA ASIA PASIFIC</h1>
    <h2>{{ $title }}</h2>
    <p>{{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Plat</th>
                <th>Nama Pengemudi</th>
                <th>Supplier</th>
                <th>Tujuan</th>
                <th>Tanggal Berangkat</th>
                <th>Status</th>
                <th>Volume (m³)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->mobil->plat ?? '-' }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->supplier ?? '-' }}</td>
                    <td>{{ $item->tujuan ?? '-' }}</td>
                    <td>
                        @if ($item->tanggal_berangkat)
                            {{ \Carbon\Carbon::parse($item->tanggal_berangkat)->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->volume ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
