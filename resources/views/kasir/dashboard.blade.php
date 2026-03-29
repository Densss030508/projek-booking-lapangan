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
            <h2>8</h2>
            <p>Booking Hari Ini</p>
        </div>

        <div class="card green">
            <h2>Rp.300.000</h2>
            <p>Total Transaksi</p>
        </div>

        <div class="card orange">
            <h2>4</h2>
            <p>Lapangan Tersedia</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-box">

        <h3>Jadwal Lapangan Hari Ini</h3>
        <a href="{{ route('kasir.jadwal') }}" class="btn-lihat">Lihat Jadwal Lengkap</a>

        <br><br>

        <table>
            <tr>
                <th>Jam</th>
                <th>Lapangan A</th>
                <th>Lapangan B</th>
                <th>Lapangan C</th>
                <th>Lapangan D</th>
            </tr>

            @for ($i = 0; $i < 4; $i++)
                <tr>
                    <td>08.00</td>
                    <td><span class="kosong">Kosong</span></td>
                    <td><span class="booking">Booking</span></td>
                    <td><span class="kosong">Kosong</span></td>
                    <td><span class="kosong">Kosong</span></td>
                </tr>
            @endfor
        </table>

    </div>

@endsection
