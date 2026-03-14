@extends('layouts.admin')

@section('title', 'Tambah Lapangan')

@section('content')

    <form action="{{ route('lapangan.store') }}" method="POST">
        @csrf

        <label>Nama Lapangan</label><br>
        <input type="text" name="nama_produk" required><br><br>

        <label>Harga / Jam</label><br>
        <input type="number" name="harga_produk" required><br><br>

        <button type="submit">Simpan</button>

    </form>

@endsection
