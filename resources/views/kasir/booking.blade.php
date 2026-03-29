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

        /* LAPANGAN */
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

        /* JAM */
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
            background: #e0e0e0;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            cursor: not-allowed;
        }

        .selected {
            background: #8be0a4 !important;
        }

        /* FORM */
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
    </style>

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
                        onclick="pilihLapangan(this, '{{ $lap->id }}', '{{ $lap->nama }}', {{ $lap->harga }})">

                        <img src="{{ asset('storage/' . $lap->foto) }}">
                        <p>{{ $lap->nama }}</p>
                        <small>Rp {{ number_format($lap->harga) }}/Jam</small>
                    </div>
                @endforeach
            </div>

            <h4>2. Pilih Jam</h4>

            <div class="jam-list" id="jamContainer">
                @foreach ($jamList as $jam)
                    <div class="jam tersedia" onclick="pilihJam(this, '{{ $jam }}')">
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

                <input type="text" name="nama" placeholder="Nama">
                <input type="text" name="no_hp" placeholder="No HP">

                <input type="number" id="harga" readonly placeholder="Harga per jam">
                <input type="number" name="durasi" id="durasi" readonly placeholder="Durasi (auto)">

                <input type="number" name="total" id="total" readonly placeholder="Total">
                <input type="number" name="bayar" id="bayar" placeholder="Bayar">
                <input type="number" name="kembalian" id="kembalian" readonly placeholder="Kembalian">

                <button type="submit">Simpan Transaksi</button>
                <button type="button" onclick="cetakStruk()">Cetak Struk</button>
            </form>
        </div>

    </div>

    <script>
        let selectedJam = [];

        function pilihLapangan(el, id, nama, harga) {
            document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            document.getElementById('lapangan_id').value = id;
            document.getElementById('lapangan').value = nama;
            document.getElementById('harga').value = harga;

            // reset jam
            selectedJam = [];
            document.querySelectorAll('.jam').forEach(j => {
                j.classList.remove('selected');
            });

            hitung();
        }

        function pilihJam(el, jam) {

            if (el.classList.contains('booking')) return;

            if (selectedJam.includes(jam)) {
                selectedJam = selectedJam.filter(j => j !== jam);
                el.classList.remove('selected');
            } else {
                selectedJam.push(jam);
                el.classList.add('selected');
            }

            document.getElementById('jam').value = selectedJam.join(',');
            document.getElementById('durasi').value = selectedJam.length;

            hitung();
        }

        function hitung() {
            let harga = document.getElementById('harga').value || 0;
            let durasi = selectedJam.length;

            document.getElementById('total').value = harga * durasi;
        }

        document.getElementById('bayar').addEventListener('input', function() {
            let bayar = this.value || 0;
            let total = document.getElementById('total').value || 0;

            document.getElementById('kembalian').value = bayar - total;
        });

        function validasiBayar() {
            let bayar = document.getElementById('bayar').value;
            let total = document.getElementById('total').value;

            if (parseInt(bayar) < parseInt(total)) {
                alert('Uang kurang! Tidak bisa simpan');
                return false;
            }

            return true;
        }

        function cetakStruk() {
            window.print();
        }
    </script>

@endsection
