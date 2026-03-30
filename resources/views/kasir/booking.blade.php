@extends('layouts.kasir')

@section('title', 'Booking Lapang')

@section('content')

    <style>
        .content-wrapper {
            display: flex;
            gap: 20px;
        }

        .left {
            flex: 2;
        }

        .right {
            flex: 1;
            background: #ddd;
            padding: 15px;
            border-radius: 10px;
        }

        .lapangan {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: 0.2s;
            border: 2px solid transparent;
        }

        .card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .card.active {
            border: 2px solid #4e73df;
            background: #eef2ff;
        }

        .jam-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .jam {
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            min-width: 70px;
            text-align: center;
            font-size: 12px;
            background: #ccc;
        }

        .tersedia {
            background: #63e26c;
            color: white;
        }

        .booked {
            background: #ff6b6b !important;
            color: white;
            cursor: not-allowed;
        }

        .selected {
            background: #8be0a4 !important;
        }

        .right input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn-cetak {
            background: #28a745;
            text-align: center;
            display: block;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>

    @if (session('success'))
        <div style="background:#4CAF50;color:white;padding:10px;margin-bottom:10px;border-radius:5px;text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('last_id'))
        <a href="{{ route('kasir.struk', session('last_id')) }}" target="_blank" class="btn-cetak">
            🖨️ Cetak Struk Transaksi Terakhir
        </a>
    @endif

    @php
        $jamList = [];
        for ($i = 8; $i <= 23; $i++) {
            $jamList[] = sprintf('%02d:00', $i);
        }
    @endphp

    <div class="content-wrapper">

        <div class="left">
            <h4>1. Pilih Lapangan</h4>

            <div class="lapangan">
                @foreach ($lapangans as $lap)
                    <div class="card"
                        onclick="pilihLapangan(this, '{{ $lap->id }}', '{{ $lap->nama }}', '{{ $lap->harga }}')">
                        <img src="{{ asset('storage/' . $lap->foto) }}">
                        <p>{{ $lap->nama }}</p>
                        <small>Rp {{ number_format($lap->harga, 0, ',', '.') }}/Jam</small>
                    </div>
                @endforeach
            </div>

            <h4>2. Pilih Jam</h4>

            <div class="jam-list" id="jamContainer">
                @foreach ($jamList as $jam)
                    <div class="jam tersedia" data-jam="{{ $jam }}">
                        {{ $jam }}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="right">
            <form method="POST" action="{{ route('kasir.store') }}" onsubmit="return validasiBayar()">
                @csrf

                <input type="hidden" name="lapangan_id" id="lapangan_id">
                <input type="hidden" name="lapangan" id="lapangan">
                <input type="hidden" name="jam" id="jam">

                <!-- 🔥 FILTER TANGGAL -->
                <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required>

                <input type="text" name="nama" placeholder="Nama" required>
                <input type="text" name="no_hp" placeholder="No HP" required>

                <input type="text" id="harga" name="harga" readonly placeholder="Harga per jam">
                <input type="text" name="durasi" id="durasi" readonly placeholder="Durasi (auto)">
                <input type="text" name="total" id="total" readonly placeholder="Total">
                <input type="text" name="bayar" id="bayar" placeholder="Bayar" required>
                <input type="text" name="kembalian" id="kembalian" readonly placeholder="Kembalian">

                <button type="submit">Simpan Transaksi</button>
            </form>
        </div>

    </div>

    <script>
        let selectedJam = [];
        let hargaAsli = 0;

        // 🔥 ambil semua transaksi dari controller
        let semuaTransaksi = @json($transaksi);
        let transaksi = [];

        let tanggalInput = document.getElementById('tanggal');

        // pertama kali load
        filterTanggal();

        // saat tanggal berubah
        tanggalInput.addEventListener('change', function() {
            filterTanggal();
        });

        function filterTanggal() {
            let tgl = tanggalInput.value;

            transaksi = semuaTransaksi.filter(trx => trx.tanggal === tgl);

            selectedJam = [];
            document.getElementById('jam').value = '';
            document.getElementById('durasi').value = '';
            document.getElementById('total').value = '';

            document.querySelectorAll('.card.active').forEach(el => {
                let nama = el.querySelector('p').innerText;
                renderJam(nama);
            });
        }

        function formatRupiah(angka) {
            angka = angka.toString().replace(/\D/g, '');
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function parseRupiah(angka) {
            return parseInt(angka.toString().replace(/\./g, '')) || 0;
        }

        function pilihLapangan(el, id, nama, harga) {
            document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            document.getElementById('lapangan_id').value = id;
            document.getElementById('lapangan').value = nama;

            hargaAsli = parseInt(harga);
            document.getElementById('harga').value = formatRupiah(harga);

            selectedJam = [];
            renderJam(nama);
            hitung();
        }

        function renderJam(namaLapangan) {
            let jamDivs = document.querySelectorAll('.jam');

            jamDivs.forEach(div => {
                let jam = div.dataset.jam;
                div.classList.remove('booked', 'selected');
                div.classList.add('tersedia');

                transaksi.forEach(trx => {
                    if (trx.lapangan === namaLapangan) {
                        let range = trx.jam.split(' - ');
                        if (range.length === 2) {
                            let start = parseInt(range[0]);
                            let end = parseInt(range[1]);
                            let jamInt = parseInt(jam);

                            if (jamInt >= start && jamInt <= end) {
                                div.classList.remove('tersedia');
                                div.classList.add('booked');
                            }
                        }
                    }
                });

                div.onclick = function() {
                    pilihJam(this, jam);
                };
            });
        }

        function pilihJam(el, jam) {
            if (el.classList.contains('booked')) return;

            if (selectedJam.includes(jam)) {
                selectedJam = selectedJam.filter(j => j !== jam);
                el.classList.remove('selected');
            } else {
                selectedJam.push(jam);
                el.classList.add('selected');
            }

            selectedJam.sort();

            if (selectedJam.length > 0) {
                let jamAwal = selectedJam[0];
                let jamAkhir = selectedJam[selectedJam.length - 1];

                document.getElementById('jam').value =
                    selectedJam.length > 1 ?
                    jamAwal + ' - ' + jamAkhir :
                    jamAwal;
            }

            document.getElementById('durasi').value = selectedJam.length;

            hitung();
        }

        function hitung() {
            let durasi = selectedJam.length;
            let total = hargaAsli * durasi;

            document.getElementById('total').value = formatRupiah(total);
        }

        document.getElementById('bayar').addEventListener('input', function() {
            this.value = formatRupiah(this.value);

            let bayar = parseRupiah(this.value);
            let total = parseRupiah(document.getElementById('total').value);

            let kembali = bayar - total;
            document.getElementById('kembalian').value = kembali > 0 ? formatRupiah(kembali) : 0;
        });

        function validasiBayar() {
            let bayar = parseRupiah(document.getElementById('bayar').value);
            let total = parseRupiah(document.getElementById('total').value);

            if (bayar < total) {
                alert('Uang kurang! Tidak bisa simpan');
                return false;
            }
            return true;
        }
    </script>

@endsection
