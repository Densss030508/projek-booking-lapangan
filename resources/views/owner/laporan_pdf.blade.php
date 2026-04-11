<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            color: #555;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4f74c8;
            color: white;
            padding: 8px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }
    </style>
</head>

<body>

    <h3>Laporan Transaksi KIXA</h3>
    <p>
        Periode:
        {{ $dari ? date('d/m/Y', strtotime($dari)) : '-' }}
        s/d
        {{ $sampai ? date('d/m/Y', strtotime($sampai)) : '-' }}
        @if ($lapangan)
            | Lapangan: {{ $lapangan }}
        @endif
    </p>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Lapangan</th>
            <th>Nama</th>
            <th>Jam</th>
            <th>Durasi</th>
            <th>Total</th>
        </tr>

        @foreach ($transaksi as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($trx->tanggal)) }}</td>
                <td>{{ $trx->lapangan }}</td>
                <td>{{ $trx->nama }}</td>
                <td>{{ $trx->jam }}</td>
                <td>{{ $trx->durasi }} Jam</td>
                <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
            </tr>
        @endforeach

        <tr class="total-row">
            <td colspan="6">Total Pendapatan</td>
            <td>Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</td>
        </tr>
    </table>

</body>

</html>
