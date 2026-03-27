@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')

    <div class="dashboard-title">Dashboard Kasir</div>

    <!-- CARD -->
    <div class="card-wrapper">

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

    <!-- JADWAL -->
    <div class="jadwal-container">

        <div class="jadwal-header">
            <h3>Jadwal Lapangan Hari Ini</h3>
            <a href="#" class="btn-jadwal">Lihat Jadwal Lengkap</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Jam</th>
                    <th>Lapangan A</th>
                    <th>Lapangan B</th>
                    <th>Lapangan C</th>
                    <th>Lapangan D</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>08.00</td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status booking">Booking</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                </tr>

                <tr>
                    <td>09.00</td>
                    <td><span class="status booking">Booking</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                </tr>

                <tr>
                    <td>10.00</td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status booking">Booking</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                </tr>

                <tr>
                    <td>11.00</td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status kosong">Kosong</span></td>
                    <td><span class="status booking">Booking</span></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- STYLE -->
    <style>
        .dashboard-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* CARD */
        .card-wrapper {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: bold;
            color: #000;
        }

        .card h2 {
            margin: 0;
            font-size: 28px;
        }

        .blue {
            background: #7da2d6;
        }

        .green {
            background: #7ee2a8;
        }

        .orange {
            background: #e6a87c;
        }

        /* JADWAL */
        .jadwal-container {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 10px;
        }

        .jadwal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .btn-jadwal {
            background: #4f73c3;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ddd;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #bbb;
        }

        /* STATUS */
        .status {
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
            font-size: 12px;
        }

        .kosong {
            background: #4cd964;
        }

        .booking {
            background: #ff3b30;
        }
    </style>

@endsection
