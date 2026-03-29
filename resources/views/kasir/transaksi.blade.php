<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background: #4aa3b5;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            height: 100vh;
            background: linear-gradient(#4e73df, #224abe);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .top {
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .menu a.active,
        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .bottom {
            padding: 20px;
            text-align: center;
        }

        .logout-btn {
            margin-top: 10px;
            background: red;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 20px;
            background: #e5e5e5;
        }

        .title {
            font-size: 20px;
            font-weight: 600;
        }

        .subtitle {
            font-size: 12px;
            color: gray;
            margin-bottom: 15px;
        }

        /* FILTER */
        .filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .filter-left {
            display: flex;
            gap: 10px;
        }

        .filter input,
        .filter select {
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search {
            display: flex;
            align-items: center;
            gap: 5px;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search input {
            border: none;
            outline: none;
        }

        /* TABLE */
        .table-box {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            background: #f1f1f1;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        tr:hover {
            background: #fafafa;
        }

        .status {
            background: #4CAF50;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
        }

        .aksi {
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="{{ asset('logo.png') }}" width="70">
            </div>

            <div class="menu">
                <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
                <a href="{{ route('kasir.jadwal') }}">Jadwal Lapangan</a>
                <a href="{{ route('kasir.transaksi') }}" class="active">Transaksi</a>
                <a href="{{ route('kasir.booking') }}">Booking Lapang</a>
            </div>
        </div>

        <div class="bottom">
            <p>Kasir</p>
            <small>Dahlan</small>

            <!-- FIX 419 -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">Log Out</button>
            </form>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="title">Riwayat Transaksi</div>
        <div class="subtitle">Daftar Transaksi Yang Telah Dilakukan</div>

        <!-- FILTER -->
        <div class="filter">
            <div class="filter-left">
                <input type="date">
                <select>
                    <option>Semua</option>
                    <option>Hari Ini</option>
                </select>
            </div>

            <div class="search">
                🔍
                <input type="text" placeholder="Cari Nama Pelanggan / Id. Transaksi">
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-box">
            <table>
                <tr>
                    <th>No</th>
                    <th>Tanggal Booking</th>
                    <th>Lapangan</th>
                    <th>Jam Booking</th>
                    <th>Durasi</th>
                    <th>Nama Penyewa</th>
                    <th>Total Bayar</th>
                    <th>No. Hp</th>
                    <th>Id. Transaksi</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>

                @for ($i = 1; $i <= 7; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>24 Mei 2026</td>
                        <td>Lapangan Futsal A</td>
                        <td>19.00-20.00</td>
                        <td>1 Jam</td>
                        <td>Denis Irwansyah</td>
                        <td>Rp. 70.000</td>
                        <td>081234123</td>
                        <td>TRX-20260312-00{{ $i }}</td>
                        <td><span class="status">Berhasil</span></td>
                        <td class="aksi">🖨️</td>
                    </tr>
                @endfor

            </table>
        </div>

    </div>

</body>

</html>
