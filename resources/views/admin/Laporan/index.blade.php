@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')

    <style>
        .filter-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-left {
            display: flex;
            gap: 10px;
        }

        .filter-box input,
        .filter-box select {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            gap: 5px;
        }

        .search-box input {
            border: none;
            outline: none;
        }

        .btn-filter {
            background: #4f73c7;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-filter:hover {
            background: #3b63c5;
        }
    </style>

    <div class="header">
        <h2>Laporan Transaksi</h2>
    </div>

    {{-- 🔥 FILTER --}}
    <form method="GET">
        <div class="filter-box">

            <div class="filter-left">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">

                <select name="filter">
                    <option value="">Semua</option>
                    <option value="hari" {{ request('filter') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>

            <div class="search-box">
                🔍
                <input type="text" name="search" placeholder="Cari Nama / Kode Transaksi"
                    value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn-filter">Filter</button>

        </div>
    </form>

    {{-- 🔥 LOGIC FILTER --}}
    @php
        $data = $transaksi;

        // 🔍 SEARCH
        if (request('search')) {
            $data = $data->filter(function ($item) {
                return str_contains(strtolower($item->nama), strtolower(request('search'))) ||
                    str_contains(strtolower($item->kode_transaksi), strtolower(request('search')));
            });
        }

        // 📅 TANGGAL SPESIFIK
        if (request('tanggal')) {
            $data = $data->where('tanggal', request('tanggal'));
        }

        // 📅 FILTER
        if (request('filter') == 'hari') {
            $data = $data->where('tanggal', date('Y-m-d'));
        }

        if (request('filter') == 'bulan') {
            $data = $data->filter(function ($item) {
                return date('Y-m', strtotime($item->tanggal)) == date('Y-m');
            });
        }

        if (request('filter') == 'tahun') {
            $data = $data->filter(function ($item) {
                return date('Y', strtotime($item->tanggal)) == date('Y');
            });
        }
    @endphp

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

            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d M Y', strtotime($item->tanggal)) }}</td>
                    <td>{{ $item->lapangan }}</td>
                    <td>{{ $item->jam }}</td>
                    <td>{{ $item->durasi }} Jam</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td><span class="status-active">Berhasil</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada transaksi</td>
                </tr>
            @endforelse

        </tbody>
    </table>

@endsection
