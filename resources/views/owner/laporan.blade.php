@extends('layouts.owner')

@section('content')
    <h3>Laporan Transaksi</h3>

    <div class="box">

        <input type="date"> sampai
        <input type="date">
        <button class="btn btn-green">Cari</button>

        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Lapangan</th>
                <th>Jam</th>
                <th>Durasi</th>
                <th>Nama</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            @for ($i = 1; $i <= 7; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>24 Mei 2026</td>
                    <td>Lapangan A</td>
                    <td>19.00</td>
                    <td>1 Jam</td>
                    <td>Denis</td>
                    <td>Rp. 70.000</td>
                    <td><span class="badge">Berhasil</span></td>
                </tr>
            @endfor

        </table>

    </div>
@endsection
