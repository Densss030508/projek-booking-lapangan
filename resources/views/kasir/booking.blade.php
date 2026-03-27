@extends('layouts.kasir')

@section('title', 'Booking Lapangan')

@section('content')

    <div class="title">Kelola Lapangan Kasir</div>
    <p class="subtitle">Kelola Booking Dan Pembayaran Pelanggan</p>

    <div class="container-booking">

        <!-- LEFT -->
        <div class="left">

            <!-- PILIH LAPANGAN -->
            <h4>1. Pilih Lapangan</h4>

            <div class="lapangan-list">

                @for ($i = 1; $i <= 4; $i++)
                    <div class="lapangan-card">
                        <img src="https://via.placeholder.com/150" alt="">
                        <p><b>Lapangan {{ chr(64 + $i) }}</b></p>
                        <p>Rp. 120.000 / Jam</p>
                        <span class="status tersedia">Tersedia</span>
                    </div>
                @endfor

            </div>

            <!-- PILIH JAM -->
            <h4>2. Pilih Tanggal Dan Jam Bermain</h4>

            <div class="jam-list">
                <span class="jam tersedia">08.00</span>
                <span class="jam tersedia">09.00</span>
                <span class="jam booking">Sudah Booking</span>
                <span class="jam tersedia">11.00</span>
                <span class="jam tersedia">12.00</span>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="right">

            <h4>Ringkasan</h4>

            <input type="text" placeholder="Nama Pelanggan">
            <input type="text" placeholder="No. Hp Pelanggan">
            <input type="text" placeholder="Durasi">

            <input type="text" placeholder="Harga / Jam" value="120000" readonly>

            <div class="summary">
                <p>Total Harga : Rp. 120.000</p>
                <p>Uang Pelanggan : Rp. 150.000</p>
                <p>Kembalian : Rp. 30.000</p>
            </div>

            <button class="btn-simpan">Simpan Transaksi</button>
            <button class="btn-cetak">Cetak Struk Transaksi</button>

        </div>

    </div>

    <style>
        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .container-booking {
            display: flex;
            gap: 20px;
        }

        /* LEFT */
        .left {
            flex: 2;
        }

        .lapangan-list {
            display: flex;
            gap: 15px;
        }

        .lapangan-card {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            width: 150px;
            text-align: center;
        }

        .lapangan-card img {
            width: 100%;
            border-radius: 10px;
        }

        .status {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 5px;
        }

        .tersedia {
            background: #4cd964;
            color: white;
        }

        /* JAM */
        .jam-list {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .jam {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .jam.tersedia {
            background: #4cd964;
            color: white;
        }

        .jam.booking {
            background: #ff3b30;
            color: white;
        }

        /* RIGHT */
        .right {
            flex: 1;
            background: #eee;
            padding: 15px;
            border-radius: 10px;
        }

        .right input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .summary {
            background: #ddd;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .btn-simpan {
            width: 100%;
            padding: 10px;
            background: #4cd964;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .btn-cetak {
            width: 100%;
            padding: 10px;
            background: #4f73c3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

@endsection
