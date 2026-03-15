@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="header">
        <h2>Laporan Transaksi</h2>
        <button class="btn-tambah">+ Export Laporan</button>
    </div>

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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>24 Mei 2026</td>
                <td>Lapangan Futsal A</td>
                <td>19.00-20.00</td>
                <td>1 Jam</td>
                <td>Denis Irwansyah</td>
                <td>Rp. 70.000</td>
                <td><span class="status-active">Berhasil</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>24 Mei 2026</td>
                <td>Lapangan Futsal A</td>
                <td>19.00-20.00</td>
                <td>1 Jam</td>
                <td>Denis Irwansyah</td>
                <td>Rp. 70.000</td>
                <td><span class="status-active">Berhasil</span></td>
            </tr>
            <!-- Tambahkan baris lain sesuai data laporan -->
        </tbody>
    </table>
@endsection
