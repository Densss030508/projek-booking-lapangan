@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')

    <div class="page-title">Laporan Transaksi</div>

    <div class="box">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('owner.laporan') }}">
            <div class="filter-box" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">

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
                    <a href="{{ route('owner.laporan') }}"
                        style="background:#ccc; color:#333; border-radius:5px; text-decoration:none; padding:8px 15px;">
                        ✖ Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- EXPORT --}}
        @if ($transaksi->count() > 0)
            <div style="display:flex; gap:10px; margin-bottom:15px;">
                <a href="{{ route('owner.exportExcel', request()->query()) }}"
                    style="background:#1d6f42; color:white; border-radius:5px; text-decoration:none; padding:8px 15px;">
                    📥 Download Excel
                </a>

                <a href="{{ route('owner.exportPdf', request()->query()) }}"
                    style="background:#c0392b; color:white; border-radius:5px; text-decoration:none; padding:8px 15px;">
                    📄 Download PDF
                </a>
            </div>
        @endif

        {{-- TABLE DETAIL --}}
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <tr style="background:#f5f5f5;">
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
                        <td>{{ $item->jam }}</td>
                        <td>{{ $item->durasi }} Jam</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>
                            <span
                                style="background:#4CAF50; color:white; padding:4px 10px; border-radius:4px; font-size:12px;">
                                Berhasil
                            </span>
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
                    <tr style="font-weight:bold; background:#f0f0f0;">
                        <td colspan="8" style="text-align:right;">Total Pendapatan</td>
                        <td colspan="2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </table>
        </div>

    </div>

@endsection
