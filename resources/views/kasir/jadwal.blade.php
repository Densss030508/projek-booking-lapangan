@extends('layouts.kasir')

@section('title', 'Jadwal Lapangan')

@section('content')

    <style>
        .title {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: gray;
            margin-bottom: 20px;
        }

        .table-box {
            background: #ddd;
            padding: 15px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ccc;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #bfbfbf;
        }

        .kosong {
            background: #63e26c;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
        }
    </style>

    <div class="title">Jadwal Lapangan</div>
    <div class="subtitle">Tampilan Detail Lapangan Yang Tersedia</div>

    {{-- 🔥 FILTER TANGGAL --}}
    <form method="GET" style="margin-bottom:15px;">
        <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
        <button type="submit">Filter</button>
    </form>

    @php
        use App\Models\Transaksi;
        use App\Models\Lapangan;

        $lapangans = Lapangan::all();

        // 🔥 ambil tanggal dari filter
        $tanggal = request('tanggal', date('Y-m-d'));

        $transaksiHariIni = Transaksi::whereDate('tanggal', $tanggal)->get();

        function cekBooking($lapangan, $jam, $data)
        {
            foreach ($data as $trx) {
                if ($trx->lapangan == $lapangan) {
                    $range = explode(' - ', $trx->jam);

                    if (count($range) == 2) {
                        $start = (int) date('H', strtotime(trim($range[0])));
                        $end = (int) date('H', strtotime(trim($range[1])));

                        if ($jam >= $start && $jam <= $end) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }
    @endphp

    <div class="table-box">

        <table>
            <tr>
                <th>Jam</th>

                @foreach ($lapangans as $lap)
                    <th>{{ $lap->nama }}</th>
                @endforeach
            </tr>

            @for ($i = 8; $i <= 22; $i++)
                <tr>
                    <td>{{ sprintf('%02d.00', $i) }}</td>

                    @foreach ($lapangans as $lap)
                        <td>
                            @if (cekBooking($lap->nama, $i, $transaksiHariIni))
                                <span class="booking">Booking</span>
                            @else
                                <span class="kosong">Kosong</span>
                            @endif
                        </td>
                    @endforeach

                </tr>
            @endfor

        </table>

    </div>

@endsection
