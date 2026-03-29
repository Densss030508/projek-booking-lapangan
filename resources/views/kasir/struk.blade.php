<!DOCTYPE html>
<html>

<body onload="window.print()">

    <h3>STRUK</h3>
    <hr>

    <p>Nama: {{ $data->nama }}</p>
    <p>Lapangan: {{ $data->lapangan }}</p>
    <p>Jam: {{ $data->jam }}</p>

    <hr>

    <p>Total: {{ $data->total }}</p>
    <p>Bayar: {{ $data->bayar }}</p>
    <p>Kembali: {{ $data->kembalian }}</p>

</body>

</html>
