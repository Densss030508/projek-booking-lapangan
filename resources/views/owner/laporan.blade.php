@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')

    <div class="page-title">Laporan Transaksi</div>

    <div class="box">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('owner.laporan') }}">
            <div class="filter-box" style="flex-wrap:wrap; gap:10px; margin-bottom:20px;">

                <input type="date" name="dari" value="{{ $dari ?? '' }}"
                    style="padding:8px; border:1px solid #ccc; border-radius:5px;">

                <span style="line-height:36px;">sampai</span>

                <input type="date" name="sampai" value="{{ $sampai ?? '' }}"
                    style="padding:8px; border:1px solid #ccc; border-radius:5px;">

                <select name="lapangan" style="padding:8px; border:1px solid #ccc; border-radius:5px;">
                    <option value="">Semua Lapangan</option>
                    @foreach ($lapangans as $lap)
                        <option value="{{ $lap->nama }}" {{ ($lapangan ?? '') == $lap->nama ? 'selected' : '' }}>
                            {{ $lap->nama }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-blue">🔍 Cari</button>

                @if (!empty($dari) || !empty($sampai) || !empty($lapangan))
                    <a href="{{ route('owner.laporan') }}" class="btn"
                        style="background:#ccc; color:#333; border-radius:5px; text-decoration:none; padding:5px 10px;">
                        ✖ Reset
                    </a>
                @endif

            </div>
        </form>

        {{-- TOMBOL EXPORT --}}
        @if (isset($transaksi) && $transaksi->count() > 0)
            <div style="display:flex; gap:10px; margin-bottom:15px;">
                <a href="{{ route('owner.exportExcel', request()->query()) }}" class="btn"
                    style="background:#1d6f42; color:white; border-radius:5px; text-decoration:none; padding:8px 15px;">
                    📥 Download Excel
                </a>
                <a href="{{ route('owner.exportPdf', request()->query()) }}" class="btn"
                    style="background:#c0392b; color:white; border-radius:5px; text-decoration:none; padding:8px 15px;">
                    📄 Download PDF
                </a>
            </div>
        @endif

        {{-- TABEL --}}
        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Lapangan</th>
                <th>Nama</th>
                <th>Jam</th>
                <th>Durasi</th>
                <th>Total</th>
            </tr>

            @if (isset($transaksi) && $transaksi->count() > 0)
                @foreach ($transaksi as $i => $trx)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($trx->tanggal)) }}</td>
                        <td>{{ $trx->lapangan }}</td>
                        <td>{{ $trx->nama }}</td>
                        <td>{{ $trx->jam }}</td>
                        <td>{{ $trx->durasi }} Jam</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td colspan="6" style="text-align:right;">Total Pendapatan</td>
                    <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="7" style="text-align:center; color:#999; padding:20px;">
                        Silakan pilih filter tanggal lalu klik Cari.
                    </td>
                </tr>
            @endif

        </table>

    </div>

@endsection
