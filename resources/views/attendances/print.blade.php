<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 2px 4px;
            /* dikurangi biar rapat */
            line-height: 1.5;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .subheader {
            text-align: center;
            font-size: 11px;
            margin-bottom: 6px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 3px 0;
        }

        .info-table {
            width: 100%;
            font-size: 12px;
        }

        .info-table td {
            vertical-align: top;
            padding: 0;
        }

        .label {
            width: 65px;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <div class="header">PT. MANGGALA ASIA PASIFIC</div>
    <div class="subheader">SURAT BONGKAR</div>

    <table class="info-table">
        <tr class="bold">
            <td class="label">No. Struk</td>
            <td>: {{ $attendance->id }}</td>
        </tr>
        <tr class="bold">
            <td>No. Pol</td>
            <td>: {{ $attendance->mobil->plat ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>
                @if ($attendance->tanggal_berangkat)
                    : {{ \Carbon\Carbon::parse($attendance->tanggal_berangkat)->format('d-m-Y H:i') }}
                @else
                    : -
                @endif
            </td>
        </tr>
        <tr>
            <td>Operator</td>
            <td>: {{ $attendance->user->name }}</td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td>: {{ $attendance->supplier ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>: {{ $attendance->tujuan ?? '-' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table class="info-table">
        <tr>
            <td class="label">Panjang</td>
            <td>: {{ $attendance->panjang ?? 0 }} cm</td>
        </tr>
        <tr>
            <td>Lebar</td>
            <td>: {{ $attendance->lebar ?? 0 }} cm</td>
        </tr>
        <tr>
            <td>Tinggi</td>
            <td>: {{ $attendance->tinggi ?? 0 }} cm</td>
        </tr>
        <tr>
            <td>Plus</td>
            <td>: {{ $attendance->plus ?? 0 }} cm</td>
        </tr>
        <tr class="bold">
            <td>Volume</td>
            <td>: {{ number_format($attendance->volume ?? 0, 2) }} m³</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="footer">
        <small>Terima kasih — {{ now()->format('d/m/Y H:i') }}</small>
    </div>

</body>

</html>
