@extends('layouts.owner')

@section('title', 'Detail Lapangan')

@section('content')

    <div class="page-title">Detail Lapangan</div>

    <a href="{{ route('owner.produk') }}" class="btn btn-blue"
        style="display:inline-block; margin-bottom:20px; border-radius:5px; text-decoration:none;">
        &lt; Kembali
    </a>

    <div style="display:flex; gap:25px; align-items:flex-start;">

        {{-- Foto --}}
        <div style="flex:1;">
            <img src="{{ asset('storage/' . $lapangan->foto) }}"
                style="width:100%; border-radius:10px; object-fit:cover; max-height:280px;">
        </div>

        {{-- Info --}}
        <div style="flex:1; background:white; padding:25px; border-radius:10px;">

            <h3 style="margin-bottom:20px; font-size:18px;">{{ $lapangan->nama }}</h3>

            <table style="width:100%; border-collapse:collapse;">
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:10px 0; color:#666; width:45%;">💰 Harga / Jam</td>
                    <td style="padding:10px 0; font-weight:600;">
                        Rp {{ number_format($lapangan->harga, 0, ',', '.') }}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:10px 0; color:#666;">🕐 Jam Buka</td>
                    <td style="padding:10px 0; font-weight:600;">{{ $lapangan->jam_buka }}</td>
                </tr>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:10px 0; color:#666;">🕐 Jam Tutup</td>
                    <td style="padding:10px 0; font-weight:600;">{{ $lapangan->jam_tutup }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; color:#666;">📌 Status</td>
                    <td style="padding:10px 0;">
                        <span class="badge"
                            style="background: {{ $lapangan->status === 'aktif' ? '#4ade80' : '#f28b82' }}; padding:5px 15px; border-radius:5px;">
                            {{ ucfirst($lapangan->status) }}
                        </span>
                    </td>
                </tr>
            </table>

        </div>

    </div>

@endsection
