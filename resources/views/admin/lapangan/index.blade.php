@extends('layouts.admin')

@section('title', 'Kelola Lapangan')

@section('content')

    <div class="top-bar">
        <h2>Kelola Lapangan</h2>

        <button class="btn-primary">
            + Tambah Lapangan
        </button>
    </div>

    <div class="lapangan-grid">

        @foreach ($products as $item)
            <div class="lapangan-card">
                <img src="https://images.unsplash.com/photo-1587384474964-3a06ce1ce699">

                <div class="lapangan-content">
                    <div>
                        <h3>{{ $item->nama_produk }}</h3>
                        <p>Rp {{ number_format($item->harga_produk, 0, ',', '.') }} / Jam</p>
                    </div>

                    <button class="btn-success">
                        ✏ Edit
                    </button>
                </div>
            </div>
        @endforeach

    </div>

@endsection
