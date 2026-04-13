@extends('layouts.owner')

@section('title', 'Data Produk')

@section('content')

    <div class="page-title">Data Produk</div>

    <div class="box">

        {{--  Form pencarian --}}
        <form method="GET" action="{{ route('owner.produk') }}">
            <div class="filter-box">
                <input type="text" name="cari" placeholder="Cari Lapangan..." value="{{ request('cari') }}">
                <button type="submit" class="btn btn-blue">🔍 Cari</button>
                @if (request('cari'))
                    <a href="{{ route('owner.produk') }}" class="btn" style="background:#ccc; color:#333;">✖ Reset</a>
                @endif
            </div>
        </form>

        <table>
            <tr>
                <th>Foto</th>
                <th>Nama Lapangan</th>
                <th>Harga/Jam</th>
                <th>Jam Operasional</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @forelse ($lapangans as $lap)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $lap->foto) }}"
                            style="width:70px; height:50px; object-fit:cover; border-radius:4px;">
                    </td>
                    <td>{{ $lap->nama }}</td>
                    <td>Rp {{ number_format($lap->harga, 0, ',', '.') }} / Jam</td>
                    <td>{{ $lap->jam_buka }} - {{ $lap->jam_tutup }}</td>
                    <td>
                        <span class="badge" style="background: {{ $lap->status === 'aktif' ? '#4ade80' : '#f28b82' }};">
                            {{ ucfirst($lap->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('owner.detail', $lap->id) }}" class="btn btn-blue">Detail ></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#999; padding:20px;">
                        Tidak ada lapangan ditemukan.
                    </td>
                </tr>
            @endforelse

        </table>

    </div>

@endsection
