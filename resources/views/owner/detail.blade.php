@extends('layouts.owner')

@section('content')
    <h3>Detail Lapangan Owner</h3>

    <a href="{{ route('owner.produk') }}" class="btn btn-blue">
        < Kembali</a>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:20px;">

                @foreach (['A', 'B', 'C', 'D'] as $lap)
                    <div style="background:white; padding:15px;">
                        <img src="https://via.placeholder.com/100%" style="width:100%;">

                        <h4>Lapangan {{ $lap }}</h4>
                        <small>Status: Tersedia</small><br>
                        <small>Jam: 08.00-23.00</small>

                        <p style="float:right;">RP. 120.000 / Jam</p>

                        <br><br>

                        <button class="btn btn-green">Aktif</button>
                    </div>
                @endforeach

            </div>
        @endsection
