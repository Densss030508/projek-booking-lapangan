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
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .card.active {
            border: 2px solid #4e73df;
            background: #eef2ff;
        }

        .jam-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .jam {
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            min-width: 70px;
            text-align: center;
            font-size: 12px;
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

        .right label {
            font-size: 13px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .right small {
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .right input {
            width: 100%;
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 6px;
            border: none;
        }

        .readonly {
            background: #f1f1f1;
        }

        .warning-bayar {
            color: #e74c3c;
            font-size: 12px;
            font-weight: bold;
            margin-top: -5px;
            margin-bottom: 8px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
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

        .alert-error {
            background: #e74c3c;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>

    @if (session('success'))
        <div style="background:#4CAF50;color:white;padding:10px;margin-bottom:10px;border-radius:5px;text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if (session('last_id'))
        <a href="{{ route('kasir.struk', session('last_id')) }}" target="_blank" class="btn-cetak">
            🖨️ Cetak Struk Transaksi Terakhir
        </a>
    @endif

    <div class="content-wrapper">

        <div class="left">
            <h4>1. Pilih Lapangan</h4>

            @if ($lapangans->isEmpty())
                <div style="background:#f39c12; color:white; padding:15px; border-radius:8px; text-align:center;">
                    ⚠️ Tidak ada lapangan yang tersedia saat ini.
                </div>
            @else
                <div class="lapangan">
                    @foreach ($lapangans as $lap)
                        <div class="card"
                            onclick="pilihLapangan(this, '{{ $lap->id }}', '{{ $lap->nama }}', '{{ $lap->harga }}', '{{ $lap->jam_buka }}', '{{ $lap->jam_tutup }}')">
                            <img src="{{ asset('storage/' . $lap->foto) }}">
                            <p>{{ $lap->nama }}</p>
                            <small>Rp {{ number_format($lap->harga, 0, ',', '.') }}/Jam</small><br>
                            <small>{{ substr($lap->jam_buka, 0, 5) }} - {{ substr($lap->jam_tutup, 0, 5) }}</small>
                        </div>
                    @endforeach
                </div>
            @endif

            <h4>2. Pilih Jam</h4>
            <div class="jam-list" id="jam-list">
                <small style="color:#777;">Silakan pilih lapangan terlebih dahulu</small>
            </div>
        </div>

        <div class="right">
            <form method="POST" action="{{ route('kasir.store') }}" onsubmit="return validasiBayar()">
                @csrf

                <input type="hidden" name="lapangan_id" id="lapangan_id">
                <input type="hidden" name="lapangan" id="lapangan">
                <input type="hidden" name="jam" id="jam">
                <input type="hidden" name="harga" id="harga_value">
                <input type="hidden" name="total" id="total_value">
                <input type="hidden" name="bayar" id="bayar_value">

                <label>Tanggal</label>
                <small>Wajib diisi</small>
                <input type="date" name="tanggal" id="tanggal" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                    required>

                <label>Nama Customer</label>
                <small>Wajib diisi</small>
                <input type="text" name="nama" placeholder="Masukkan nama" required>

                <label>No HP</label>
                <small>Wajib angka saja</small>
                <input type="text" name="no_hp" placeholder="Masukkan no hp" inputmode="numeric"
                    oninput="this.value = this.value.replace(/\D/g, '')" required>

                <label>Harga per Jam</label>
                <small>Otomatis dari lapangan</small>
                <input type="text" id="harga_display" class="readonly" readonly>

                <label>Durasi</label>
                <small>Otomatis dari jumlah jam dipilih</small>
                <input type="text" name="durasi" id="durasi" class="readonly" readonly>

                <label>Total</label>
                <small>Otomatis dihitung</small>
                <input type="text" id="total_display" class="readonly" readonly>

                <label>Bayar</label>
                <small>Wajib diisi kasir</small>
                <input type="text" id="bayar_display" placeholder="Masukkan uang bayar" oninput="hitungKembalian(this)"
                    required>
                <div id="warning_bayar" class="warning-bayar"></div>

                <label>Kembalian</label>
                <small>Otomatis dihitung</small>
                <input type="text" id="kembalian_display" class="readonly" readonly>

                <button type="submit">Simpan Transaksi</button>
            </form>
        </div>

    </div>

    <!-- TAMBAHAN SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let selectedJam = [];
        let hargaAsli = 0;
        let lapanganAktif = '';
        let semuaTransaksi = @json($transaksi);
        let transaksi = [];
        let tanggalInput = document.getElementById('tanggal');

        filterTanggal();

        tanggalInput.addEventListener('change', function() {
            let hariIni = new Date().toISOString().split('T')[0];

            if (this.value < hariIni) {
                alert('Tidak bisa booking tanggal yang sudah lewat!');
                this.value = hariIni;
                return;
            }

            filterTanggal();

            if (lapanganAktif) {
                let cardAktif = document.querySelector('.card.active');
                if (cardAktif) {
                    cardAktif.click();
                }
            }
        });

        function filterTanggal() {
            transaksi = semuaTransaksi.filter(trx => trx.tanggal === tanggalInput.value);
        }

        function formatRibuan(angka) {
            angka = angka.toString();
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function pilihLapangan(el, id, nama, harga, jamBuka, jamTutup) {
            document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            lapanganAktif = nama;

            document.getElementById('lapangan_id').value = id;
            document.getElementById('lapangan').value = nama;

            hargaAsli = parseInt(harga);
            document.getElementById('harga_display').value = 'Rp ' + formatRibuan(hargaAsli) + '/Jam';
            document.getElementById('harga_value').value = hargaAsli;

            selectedJam = [];
            document.getElementById('jam').value = '';
            document.getElementById('durasi').value = '';
            document.getElementById('total_display').value = '';
            document.getElementById('total_value').value = '';
            document.getElementById('bayar_display').value = '';
            document.getElementById('bayar_value').value = '';
            document.getElementById('kembalian_display').value = '';
            document.getElementById('warning_bayar').innerHTML = '';

            renderJam(nama, jamBuka, jamTutup);
        }

        function renderJam(namaLapangan, jamBuka, jamTutup) {
            let jamList = document.getElementById('jam-list');
            jamList.innerHTML = '';

            let buka = parseInt(jamBuka.split(':')[0]);
            let tutup = parseInt(jamTutup.split(':')[0]);

            for (let i = buka; i <= tutup; i++) {
                let jam = String(i).padStart(2, '0') + ':00';
                let div = document.createElement('div');
                div.className = 'jam';
                div.innerText = jam;

                let isBooked = false;

                transaksi.forEach(trx => {
                    if (trx.lapangan.trim() === namaLapangan.trim()) {
                        trx.jam.split(',').forEach(j => {
                            if (jam === j.trim()) {
                                isBooked = true;
                            }
                        });
                    }
                });

                if (isBooked) {
                    div.classList.add('booked');
                } else {
                    div.classList.add('tersedia');
                    div.onclick = function() {
                        pilihJam(div, jam);
                    };
                }

                jamList.appendChild(div);
            }
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
            document.getElementById('jam').value = selectedJam.join(',');
            document.getElementById('durasi').value = selectedJam.length;

            let total = hargaAsli * selectedJam.length;
            document.getElementById('total_display').value = 'Rp ' + formatRibuan(total);
            document.getElementById('total_value').value = total;

            let bayar = parseInt(document.getElementById('bayar_value').value) || 0;
            let kembalian = bayar - total;

            document.getElementById('kembalian_display').value =
                bayar > 0 ?
                (kembalian >= 0 ?
                    'Rp ' + formatRibuan(kembalian) :
                    'Kurang: Rp ' + formatRibuan(Math.abs(kembalian))) :
                '';

            document.getElementById('warning_bayar').innerHTML =
                bayar > 0 && bayar < total ? '⚠️ Uang customer masih kurang!' : '';
        }

        function hitungKembalian(input) {
            let angka = input.value.replace(/\D/g, '');
            input.value = angka ? formatRibuan(angka) : '';
            document.getElementById('bayar_value').value = angka;

            let bayar = parseInt(angka) || 0;
            let total = parseInt(document.getElementById('total_value').value) || 0;
            let kembalian = bayar - total;

            document.getElementById('kembalian_display').value =
                bayar > 0 ?
                (kembalian >= 0 ?
                    'Rp ' + formatRibuan(kembalian) :
                    'Kurang: Rp ' + formatRibuan(Math.abs(kembalian))) :
                '';

            document.getElementById('warning_bayar').innerHTML =
                bayar > 0 && bayar < total ? '⚠️ Uang customer masih kurang!' : '';
        }

        function validasiBayar() {
            let bayar = parseInt(document.getElementById('bayar_value').value) || 0;
            let total = parseInt(document.getElementById('total_value').value) || 0;
            let tanggal = document.getElementById('tanggal').value;
            let hariIni = new Date().toISOString().split('T')[0];

            if (tanggal < hariIni) {
                alert('Tanggal booking tidak boleh tanggal yang sudah lewat!');
                return false;
            }

            if (!document.getElementById('lapangan_id').value) {
                alert('Pilih lapangan terlebih dahulu!');
                return false;
            }

            if (!document.getElementById('jam').value) {
                alert('Pilih jam terlebih dahulu!');
                return false;
            }

            if (bayar < total) {
                Swal.fire({
                    icon: 'error',
                    title: 'Uang Kurang!',
                    text: 'Nominal pembayaran customer masih kurang.',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            return true;
        }
    </script>

@endsection
