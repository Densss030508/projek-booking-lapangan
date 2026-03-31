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
            background: #4e73df !important;
            color: white;
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
                        {{-- ✅ Format harga: Rp 120.000/Jam --}}
                        <small>Rp {{ number_format($lap->harga, 0, ',', '.') }}/Jam</small>
                    </div>
                @endforeach
            </div>

            <h4>2. Pilih Jam</h4>

            <div class="jam-list">
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
                {{-- Input hidden untuk nilai asli (angka murni) --}}
                <input type="hidden" name="harga" id="harga_value">
                <input type="hidden" name="total" id="total_value">
                <input type="hidden" name="bayar" id="bayar_value">
                <input type="hidden" name="kembalian" id="kembalian_value">

                <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required>

                <input type="text" name="nama" placeholder="Nama" required>
                <input type="text" name="no_hp" placeholder="No HP" required>

                {{-- Tampilan saja (readonly, format ribuan) --}}
                <input type="text" id="harga_display" readonly placeholder="Harga per jam">
                <input type="text" name="durasi" id="durasi" readonly placeholder="Durasi (auto)">
                <input type="text" id="total_display" readonly placeholder="Total">
                <input type="text" id="bayar_display" placeholder="Bayar" oninput="hitungKembalian(this)" required>
                <input type="text" id="kembalian_display" readonly placeholder="Kembalian">

                <button type="submit">Simpan Transaksi</button>
            </form>
        </div>

    </div>

    <script>
        let selectedJam = [];
        let hargaAsli = 0;

        let semuaTransaksi = @json($transaksi);
        let transaksi = [];

        let tanggalInput = document.getElementById('tanggal');

        filterTanggal();

        tanggalInput.addEventListener('change', filterTanggal);

        function filterTanggal() {
            let tgl = tanggalInput.value;

            transaksi = semuaTransaksi.filter(trx => trx.tanggal === tgl);

            selectedJam = [];
            document.getElementById('jam').value = '';
            document.getElementById('durasi').value = '';
            document.getElementById('total_display').value = '';
            document.getElementById('total_value').value = '';

            document.querySelectorAll('.card.active').forEach(el => {
                let nama = el.querySelector('p').innerText;
                renderJam(nama);
            });
        }

        // ✅ Format angka jadi ribuan: 120000 → 120.000
        function formatRibuan(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function pilihLapangan(el, id, nama, harga) {
            document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            document.getElementById('lapangan_id').value = id;
            document.getElementById('lapangan').value = nama;

            hargaAsli = parseInt(harga);

            // ✅ Tampilan harga format Rp 120.000/Jam
            document.getElementById('harga_display').value = 'Rp ' + formatRibuan(hargaAsli) + '/Jam';
            document.getElementById('harga_value').value = hargaAsli;

            selectedJam = [];
            renderJam(nama);
        }

        function renderJam(namaLapangan) {
            document.querySelectorAll('.jam').forEach(div => {

                let jam = div.dataset.jam;
                let jamInt = parseInt(jam);

                div.classList.remove('booked', 'selected');
                div.classList.add('tersedia');

                transaksi.forEach(trx => {
                    if (trx.lapangan === namaLapangan) {

                        // 🔥 RANGE
                        if (trx.jam.includes('-')) {
                            let range = trx.jam.split('-');
                            let start = parseInt(range[0]);
                            let end = parseInt(range[1]);

                            if (jamInt >= start && jamInt <= end) {
                                div.classList.remove('tersedia');
                                div.classList.add('booked');
                            }
                        } else {
                            // 🔥 CUSTOM
                            let arr = trx.jam.split(',');
                            arr.forEach(j => {
                                if (jamInt === parseInt(j)) {
                                    div.classList.remove('tersedia');
                                    div.classList.add('booked');
                                }
                            });
                        }
                    }
                });

                // 🔥 DISABLE CLICK kalau booked
                div.onclick = function() {
                    if (div.classList.contains('booked')) return;
                    pilihJam(div, jam);
                };
            });
        }

        function pilihJam(el, jam) {
            if (selectedJam.includes(jam)) {
                selectedJam = selectedJam.filter(j => j !== jam);
                el.classList.remove('selected');
            } else {
                selectedJam.push(jam);
                el.classList.add('selected');
            }

            selectedJam.sort();

            if (selectedJam.length > 2) {
                document.getElementById('jam').value =
                    selectedJam[0] + ' - ' + selectedJam[selectedJam.length - 1];
            } else {
                document.getElementById('jam').value = selectedJam.join(',');
            }

            document.getElementById('durasi').value = selectedJam.length;

            let total = hargaAsli * selectedJam.length;

            // ✅ Tampilan total format Rp 240.000
            document.getElementById('total_display').value = 'Rp ' + formatRibuan(total);
            document.getElementById('total_value').value = total;

            // Reset bayar & kembalian saat jam berubah
            document.getElementById('bayar_display').value = '';
            document.getElementById('bayar_value').value = '';
            document.getElementById('kembalian_display').value = '';
            document.getElementById('kembalian_value').value = '';
        }

        // ✅ Hitung kembalian otomatis saat input bayar
        function hitungKembalian(input) {
            // Ambil angka murni dari input bayar (hapus titik)
            let angkaMurni = input.value.replace(/\D/g, '');

            // Format tampilan bayar
            input.value = formatRibuan(angkaMurni);

            // Simpan ke hidden
            document.getElementById('bayar_value').value = angkaMurni;

            let bayar = parseInt(angkaMurni) || 0;
            let total = parseInt(document.getElementById('total_value').value) || 0;

            let kembalian = bayar - total;

            if (kembalian >= 0) {
                document.getElementById('kembalian_display').value = 'Rp ' + formatRibuan(kembalian);
                document.getElementById('kembalian_value').value = kembalian;
            } else {
                document.getElementById('kembalian_display').value = 'Kurang: Rp ' + formatRibuan(Math.abs(kembalian));
                document.getElementById('kembalian_value').value = kembalian;
            }
        }

        function validasiBayar() {
            let bayar = parseInt(document.getElementById('bayar_value').value) || 0;
            let total = parseInt(document.getElementById('total_value').value) || 0;

            if (!document.getElementById('lapangan_id').value) {
                alert('Pilih lapangan terlebih dahulu!');
                return false;
            }

            if (!document.getElementById('jam').value) {
                alert('Pilih jam terlebih dahulu!');
                return false;
            }

            if (bayar < total) {
                alert('Uang kurang! Total: Rp ' + formatRibuan(total) + ', Bayar: Rp ' + formatRibuan(bayar));
                return false;
            }
            return true;
        }
    </script>

@endsection
