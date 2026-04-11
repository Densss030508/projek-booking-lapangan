@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')

    <style>
        .filter-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .filter-box {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-box input,
        .filter-box select {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            min-width: 160px;
        }

        .btn-filter {
            background: #4f74c8;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-reset {
            background: #ccc;
            color: #333;
            padding: 9px 15px;
            border-radius: 6px;
            text-decoration: none;
        }

        .export-box {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-excel {
            background: #1d6f42;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            padding: 9px 15px;
            font-weight: 500;
        }

        .btn-pdf {
            background: #c0392b;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            padding: 9px 15px;
            font-weight: 500;
        }

        .table-box {
            overflow-x: auto;
            border-radius: 8px;
        }

        .table-laporan {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table-laporan th {
            background: #f5f5f5;
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        .table-laporan td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .status-success {
            background: #4CAF50;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
        }

        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }
    </style>

    <div class="page-title">Laporan Transaksi</div>

    <div class="box">

        {{-- FILTER + EXPORT --}}
        <div class="filter-wrapper">

            {{-- FILTER --}}
            <form method="GET" action="{{ route('owner.laporan') }}">
                <div class="filter-box">

                    <input type="date" name="dari" value="{{ $dari ?? '' }}">

                    <span>sampai</span>

                    <input type="date" name="sampai" value="{{ $sampai ?? '' }}">

                    <select name="lapangan">
                        <option value="">Semua Lapangan</option>
                        @foreach ($lapangans as $lap)
                            <option value="{{ $lap->nama }}" {{ ($lapangan ?? '') == $lap->nama ? 'selected' : '' }}>
                                {{ $lap->nama }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-filter">🔍 Cari</button>

                    @if (!empty($dari) || !empty($sampai) || !empty($lapangan))
                        <a href="{{ route('owner.laporan') }}" class="btn-reset">
                            ✖ Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- EXPORT --}}
            @if ($transaksi->count() > 0)
                <div class="export-box">
                    <a href="{{ route('owner.exportExcel', request()->query()) }}" class="btn-excel">
                        📥 Download Excel
                    </a>

                    <a href="{{ route('owner.exportPdf', request()->query()) }}" class="btn-pdf">
                        📄 Download PDF
                    </a>
                </div>
            @endif

        </div>

        {{-- TABLE --}}
        <div class="table-box">
            <table class="table-laporan">
                <tr>
                    <th>No</th>
                    <th>Tanggal Booking</th>
                    <th>Lapangan</th>
                    <th>Jam Booking</th>
                    <th>Durasi</th>
                    <th>Nama Penyewa</th>
                    <th>No. HP</th>
                    <th>ID Transaksi</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>

                @forelse ($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                        <td>{{ $item->lapangan }}</td>

                        <td>
                            @php
                                $jamArray = array_map('trim', explode(',', $item->jam));
                                $jumlahJam = count($jamArray);
                            @endphp

                            @if ($jumlahJam >= 4)
                                {{ $jamArray[0] }} - {{ end($jamArray) }}
                            @else
                                {{ implode(', ', $jamArray) }}
                            @endif
                        </td>

                        <td>{{ $item->durasi }} Jam</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-success">Berhasil</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:20px;">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse

                @if ($transaksi->count() > 0)
                    <tr class="total-row">
                        <td colspan="8" style="text-align:right;">Total Pendapatan</td>
                        <td colspan="2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </table>
        </div>

    </div>

@endsection
