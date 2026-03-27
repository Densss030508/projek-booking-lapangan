@extends('layouts.owner')

@section('content')
    <h3>Data Produk</h3>

    <div class="box">

        <input type="text" placeholder="Cari Lapangan...">
        <select>
            <option>Semua Jenis</option>
        </select>
        <button class="btn btn-blue">Filter</button>

        <table>
            <tr>
                <th>Foto</th>
                <th>Nama Lapangan</th>
                <th>Jenis</th>
                <th>Harga/Jam</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @for ($i = 0; $i < 4; $i++)
                <tr>
                    <td><img src="https://via.placeholder.com/70"></td>
                    <td>Lapangan Futsal A</td>
                    <td>Rumput Sintetis</td>
                    <td>Rp. 70.000</td>
                    <td>08.00-23.00</td>
                    <td><span class="badge">Aktif</span></td>
                    <td>
                        <a href="{{ route('owner.detail') }}" class="btn btn-blue">Detail ></a>
                    </td>
                </tr>
            @endfor

        </table>

    </div>
@endsection
