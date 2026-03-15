@extends('layouts.admin')

@section('title', 'Kelola Lapangan')

@section('content')

    <div class="header">
        <h2>Kelola Lapangan Admin</h2>
        <button class="btn-tambah">+ Tambah Lapangan</button>
    </div>

    <div class="lapangan-grid">

        <!-- CARD 1 -->
        <div class="card">
            <img src="https://i.imgur.com/8zQZ7mC.jpg">

            <div class="card-title">Lapangan A</div>

            <div class="card-info">
                Status: Tersedia <br>
                Jam Operasi : <br>
                08.00 - 23.00
            </div>

            <div class="card-bottom">
                <div class="price">RP. 120.000 / Jam</div>
                <button class="btn-edit">Edit</button>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="card">
            <img src="https://i.imgur.com/8zQZ7mC.jpg">

            <div class="card-title">Lapangan B</div>

            <div class="card-info">
                Status: Tersedia <br>
                Jam Operasi : <br>
                08.00 - 23.00
            </div>

            <div class="card-bottom">
                <div class="price">RP. 120.000 / Jam</div>
                <button class="btn-edit">Edit</button>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="card">
            <img src="https://i.imgur.com/8zQZ7mC.jpg">

            <div class="card-title">Lapangan C</div>

            <div class="card-info">
                Status: Tersedia <br>
                Jam Operasi : <br>
                08.00 - 23.00
            </div>

            <div class="card-bottom">
                <div class="price">RP. 120.000 / Jam</div>
                <button class="btn-edit">Edit</button>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="card">
            <img src="https://i.imgur.com/8zQZ7mC.jpg">

            <div class="card-title">Lapangan D</div>

            <div class="card-info">
                Status: Tersedia <br>
                Jam Operasi : <br>
                08.00 - 23.00
            </div>

            <div class="card-bottom">
                <div class="price">RP. 120.000 / Jam</div>
                <button class="btn-edit">Edit</button>
            </div>
        </div>
        ```

    </div>

@endsection
