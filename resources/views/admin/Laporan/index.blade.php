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

    {{-- FILTER --}}
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

    {{--  LOGIC FILTER (FIX: pakai Carbon::parse agar format tanggal cocok) --}}
    @php
        use Carbon\Carbon;

        $data = $transaksi;

        // 🔍 SEARCH
        if (request('search')) {
            $keyword = strtolower(request('search'));
            $data = $data->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item->nama), $keyword) ||
                    str_contains(strtolower($item->kode_transaksi), $keyword);
            });
        }

        // 📅 TANGGAL SPESIFIK
        if (request('tanggal')) {
            $tglCari = request('tanggal'); // format Y-m-d
            $data = $data->filter(function ($item) use ($tglCari) {
                return Carbon::parse($item->tanggal)->format('Y-m-d') === $tglCari;
            });
        }

        // 📅 FILTER HARI INI
        if (request('filter') == 'hari') {
            $data = $data->filter(function ($item) {
                return Carbon::parse($item->tanggal)->isToday();
            });
        }

        // 📅 FILTER BULAN INI
        if (request('filter') == 'bulan') {
            $data = $data->filter(function ($item) {
                return Carbon::parse($item->tanggal)->month == Carbon::now()->month &&
                    Carbon::parse($item->tanggal)->year == Carbon::now()->year;
            });
        }

        // 📅 FILTER TAHUN INI
        if (request('filter') == 'tahun') {
            $data = $data->filter(function ($item) {
                return Carbon::parse($item->tanggal)->year == Carbon::now()->year;
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
                    <td>{{ Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->lapangan }}</td>
                    <td>{{ $item->jam }}</td>
                    <td>{{ $item->durasi }} Jam</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td><span class="status-active">Berhasil</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#999; padding:20px;">
                        Belum ada transaksi
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

@endsection
