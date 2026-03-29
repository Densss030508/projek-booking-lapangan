@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')

    <div class="page-title">Dashboard Owner</div>

    <div class="card-box">

        <div class="card blue">
            <i>📄</i>
            <div>
                <h2>8</h2>
                <p>Total Transaksi Hari Ini</p>
            </div>
        </div>

        <div class="card green">
            <i>💰</i>
            <div>
                <h2>Rp. 300.000</h2>
                <p>Total Pendapatan Hari Ini</p>
            </div>
        </div>

        <div class="card orange">
            <i>📊</i>
            <div>
                <h2>Rp. 10.000.000</h2>
                <p>Total Pendapatan Bulan Ini</p>
            </div>
        </div>

        <div class="card red">
            <i>🏟️</i>
            <div>
                <h2>4</h2>
                <p>Total Lapangan Aktif</p>
            </div>
        </div>

    </div>

    <div class="box">
        <h4>Statistik Booking Mingguan</h4>

        <div class="chart">
            Grafik disini (nanti pakai Chart.js)
        </div>
    </div>

@endsection
