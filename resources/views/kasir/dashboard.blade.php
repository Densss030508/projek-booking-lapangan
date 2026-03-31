@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')

    <style>
        .title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* CARD */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            color: black;
            text-align: center;
        }

        .blue {
            background: #7ea6d8;
        }

        .green {
            background: #8be0a4;
        }

        .orange {
            background: #e6a97c;
        }

        .card h2 {
            font-size: 28px;
        }

        /* TABLE */
        .table-box {
            background: #eee;
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
            padding: 10px;
            border: 1px solid #888;
            text-align: center;
        }

        .kosong {
            background: #63e26c;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .btn-lihat {
            float: right;
            background: #7ea6d8;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="title">Dashboard Kasir</div>

    <!-- CARDS -->
    <div class="cards">
        <div class="card blue">
            <h2>{{ $jumlahBooking }}</h2>
            <p>Booking Hari Ini</p>
        </div>

        <div class="card green">
            <h2>Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</h2>
            <p>Total Transaksi</p>
        </div>

        <div class="card orange">
            <h2>{{ $jumlahLapangan }}</h2>
            <p>Lapangan Tersedia</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-box">

        <h3>Jadwal Lapangan Hari Ini</h3>
        <a href="{{ route('kasir.jadwal') }}" class="btn-lihat">Lihat Jadwal Lengkap</a>

        <br><br>

        @php
            function cekBookingDashboard($lapangan, $jam, $data)
            {
                foreach ($data as $trx) {
                    if ($trx->lapangan == $lapangan) {
                        // RANGE
                        if (str_contains($trx->jam, '-')) {
                            $range = explode('-', $trx->jam);
                            $start = (int) date('H', strtotime(trim($range[0])));
                            $end = (int) date('H', strtotime(trim($range[1])));

                            if ($jam >= $start && $jam <= $end) {
                                return true;
                            }
                        } else {
                            // CUSTOM
                            $arr = explode(',', $trx->jam);

                            foreach ($arr as $j) {
                                $jamDb = (int) date('H', strtotime(trim($j)));

                                if ($jam == $jamDb) {
                                    return true;
                                }
                            }
                        }
                    }
                }

                return false;
            }
        @endphp

        <table>
            <tr>
                <th>Jam</th>

                @foreach ($lapangans as $lap)
                    <th>{{ $lap->nama }}</th>
                @endforeach
            </tr>

            @for ($i = 8; $i <= 12; $i++)
                <tr>
                    <td>{{ sprintf('%02d.00', $i) }}</td>

                    @foreach ($lapangans as $lap)
                        <td>
                            @if (cekBookingDashboard($lap->nama, $i, $transaksiHariIni))
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
