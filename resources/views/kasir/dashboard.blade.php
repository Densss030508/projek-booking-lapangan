@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')

    <style>
        /* =========================
               TAMBAHAN: PERBAIKI LOGO
               ========================= */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 120px;
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .title {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .tanggal-hari-ini {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
        }

        /* CARD */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            color: black;
            text-align: center;
        }

        .blue {
            background: #7ea6d8;
        }

        .green {
            background: #8be0a4;
        }

        .orange {
            background: #e6a97c;
        }

        .card h2 {
            font-size: 28px;
        }

        /* TABLE */
        .table-box {
            background: #eee;
            padding: 15px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ccc;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #888;
            text-align: center;
        }

        .kosong {
            background: #63e26c;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .btn-lihat {
            float: right;
            background: #7ea6d8;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }

        /* FILTER TANGGAL */
        .filter-tanggal {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-tanggal input[type="date"] {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #aaa;
            font-size: 14px;
        }
    </style>

    <div class="title">Dashboard Kasir</div>

    <div class="tanggal-hari-ini" id="labelTanggal">
        📅 {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>

    <!-- FILTER TANGGAL -->
    <div class="filter-tanggal">
        <label><strong>Filter Tanggal:</strong></label>
        <input type="date" id="filterTanggal" value="{{ date('Y-m-d') }}">
    </div>

    <!-- CARD -->
    <div class="cards">
        <div class="card blue">
            <h2 id="cardBooking">{{ $jumlahBooking }}</h2>
            <p>Booking Hari Ini</p>
        </div>

        <div class="card green">
            <h2 id="cardTransaksi">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</h2>
            <p>Total Transaksi</p>
        </div>

        <div class="card orange">
            <h2>{{ $jumlahLapangan }}</h2>
            <p>Lapangan Tersedia</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-box">

        <h3>
            Jadwal Lapangan —
            <span id="labelJadwal">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
        </h3>

        <a href="{{ route('kasir.jadwal') }}" class="btn-lihat">
            Lihat Jadwal Lengkap
        </a>

        <br><br>

        @php
            function cekBookingDashboard($lapangan, $jam, $data)
            {
                foreach ($data as $trx) {
                    if ($trx->lapangan == $lapangan) {
                        if (str_contains($trx->jam, '-')) {
                            $range = explode('-', $trx->jam);
                            $start = (int) date('H', strtotime(trim($range[0])));
                            $end = (int) date('H', strtotime(trim($range[1])));

                            if ($jam >= $start && $jam <= $end) {
                                return true;
                            }
                        } else {
                            $arr = explode(',', $trx->jam);

                            foreach ($arr as $j) {
                                $jamDb = (int) date('H', strtotime(trim($j)));

                                if ($jam == $jamDb) {
                                    return true;
                                }
                            }
                        }
                    }
                }

                return false;
            }
        @endphp

        <table id="tabelJadwal">
            <tr>
                <th>Jam</th>

                @foreach ($lapangans as $lap)
                    <th>{{ $lap->nama }}</th>
                @endforeach
            </tr>

            @for ($i = 8; $i <= 12; $i++)
                <tr>
                    <td>{{ sprintf('%02d.00', $i) }}</td>

                    @foreach ($lapangans as $lap)
                        <td>
                            @if (cekBookingDashboard($lap->nama, $i, $transaksiHariIni))
                                <span class="booking">Booking</span>
                            @else
                                <span class="kosong">Kosong</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
        </table>
    </div>

    <script>
        const lapangans = @json($lapangans->pluck('nama'));

        function formatTanggalIndo(dateStr) {
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const d = new Date(dateStr + 'T00:00:00');

            return hari[d.getDay()] + ', ' +
                String(d.getDate()).padStart(2, '0') + ' ' +
                bulan[d.getMonth()] + ' ' +
                d.getFullYear();
        }

        document.getElementById('filterTanggal').addEventListener('change', function() {
            const tanggal = this.value;

            document.getElementById('labelTanggal').innerHTML =
                '📅 ' + formatTanggalIndo(tanggal);

            const d = new Date(tanggal + 'T00:00:00');
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            document.getElementById('labelJadwal').innerText =
                String(d.getDate()).padStart(2, '0') + ' ' +
                bulan[d.getMonth()] + ' ' +
                d.getFullYear();

            fetch('{{ route('kasir.dashboardFilter') }}?tanggal=' + tanggal)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cardBooking').innerText =
                        data.jumlahBooking;

                    document.getElementById('cardTransaksi').innerText =
                        data.totalTransaksi;

                    let html = '<tr><th>Jam</th>';

                    lapangans.forEach(n => html += '<th>' + n + '</th>');
                    html += '</tr>';

                    data.jadwal.forEach(row => {
                        html += '<tr><td>' + row.jam + '</td>';

                        row.lapangans.forEach(lap => {
                            html += '<td>' + (lap.booked ?
                                '<span class="booking">Booking</span>' :
                                '<span class="kosong">Kosong</span>') + '</td>';
                        });

                        html += '</tr>';
                    });

                    document.getElementById('tabelJadwal').innerHTML = html;
                });
        });
    </script>

@endsection
