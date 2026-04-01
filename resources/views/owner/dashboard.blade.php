@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')

    <div class="page-title">Dashboard Owner</div>

    <div class="card-box">

        <div class="card blue">
            <i>📄</i>
            <div>
                <h2>{{ $totalTransaksiHariIni }}</h2>
                <p>Total Transaksi Hari Ini</p>
            </div>
        </div>

        <div class="card green">
            <i>💰</i>
            <div>
                <h2>Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</h2>
                <p>Total Pendapatan Hari Ini</p>
            </div>
        </div>

        <div class="card orange">
            <i>📊</i>
            <div>
                <h2>Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</h2>
                <p>Total Pendapatan Bulan Ini</p>
            </div>
        </div>

        <div class="card red">
            <i>🏟️</i>
            <div>
                <h2>{{ $totalLapangan }}</h2>
                <p>Total Lapangan Aktif</p>
            </div>
        </div>

    </div>

    <div class="box">
        <h4>Statistik Booking Mingguan</h4>

        <div class="chart">
            <canvas id="chartMingguan"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json(collect($mingguan)->pluck('label'));
        const data = @json(collect($mingguan)->pluck('jumlah'));

        new Chart(document.getElementById('chartMingguan'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: data,
                    backgroundColor: '#7ea6d8',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

@endsection
