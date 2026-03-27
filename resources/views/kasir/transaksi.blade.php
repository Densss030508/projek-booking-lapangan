@extends('layouts.kasir')

@section('title', 'Transaksi Kasir')

@section('content')

    <div class="title">Riwayat Transaksi</div>
    <p class="subtitle">Daftar Transaksi Yang Telah Dilakukan</p>

    <!-- FILTER -->
    <div class="filter-box">
        <input type="date">

        <select>
            <option>Semua</option>
            <option>Berhasil</option>
            <option>Pending</option>
        </select>

        <input type="text" placeholder="Cari Nama Pelanggan / Id Transaksi">
    </div>

    <!-- TABLE -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Booking</th>
                    <th>Lapangan</th>
                    <th>Jam Booking</th>
                    <th>Durasi</th>
                    <th>Nama Penyewa</th>
                    <th>Total Bayar</th>
                    <th>No. Hp</th>
                    <th>Id Transaksi</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
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
                        <td>
                            <button class="btn-print">🖨</button>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <style>
        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* FILTER */
        .filter-box {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-box input,
        .filter-box select {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* TABLE */
        .table-container {
            background: #eee;
            padding: 10px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;
            text-align: center;
        }

        th {
            background: #f1f1f1;
        }

        /* STATUS */
        .status {
            background: #4cd964;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
        }

        /* BUTTON */
        .btn-print {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
    </style>

@endsection
