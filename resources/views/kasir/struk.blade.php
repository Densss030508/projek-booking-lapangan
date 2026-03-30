<!DOCTYPE html>
<html>

<head>
    <title>Struk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: auto;
            padding: 20px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="center">
        <h3>KIXA FUTSAL</h3>
        <small>Jl. Sport No 123, Subang</small><br>
        <small>Telp: 0853-1577-7466</small>
    </div>

    <div class="line"></div>
    <div class="center"><b>BUKTI PEMBAYARAN</b></div>
    <div class="line"></div>

    <div class="row"><span>ID</span><span>{{ $data->kode_transaksi }}</span></div>
    <div class="row"><span>Nama</span><span>{{ $data->nama }}</span></div>
    <div class="row"><span>No HP</span><span>{{ $data->no_hp }}</span></div>
    <div class="row"><span>Lapangan</span><span>{{ $data->lapangan }}</span></div>
    <div class="row"><span>Jam</span><span>{{ $data->jam }}</span></div>
    <div class="row"><span>Durasi</span><span>{{ $data->durasi }} Jam</span></div>

    <div class="line"></div>

    <div class="row"><span>Harga</span><span>Rp {{ number_format($data->harga, 0, ',', '.') }}</span></div>
    <div class="row"><span>Total</span><span>Rp {{ number_format($data->total, 0, ',', '.') }}</span></div>
    <div class="row"><span>Bayar</span><span>Rp {{ number_format($data->bayar, 0, ',', '.') }}</span></div>
    <div class="row"><span>Kembali</span><span>Rp {{ number_format($data->kembalian, 0, ',', '.') }}</span></div>

    <div class="line"></div>
    <p class="center">Terima kasih 🙏</p>

</body>

</html>
