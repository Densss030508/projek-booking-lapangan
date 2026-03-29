@extends('layouts.admin')

@section('content')
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .lapangan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        .card {
            background: #f5f5f5;
            border-radius: 12px;
            overflow: hidden;
            padding: 10px;
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }

        .card-body {
            padding: 10px;
        }

        .card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .price {
            font-weight: bold;
        }

        .btn-edit {
            background: #2ecc71;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-tambah {
            background: #5c6bc0;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-tambah:hover {
            background: #3f51b5;
        }
    </style>

    <!-- HEADER -->
    <div class="header">
        <h2>Kelola Lapangan Admin</h2>

        <a href="{{ route('lapangan.create') }}" class="btn-tambah">
            + Tambah Lapangan
        </a>
    </div>

    <!-- GRID -->
    <div class="lapangan-grid">
        @forelse ($lapangan as $item)
            <div class="card">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="foto">

                <div class="card-body">
                    <h3>{{ $item->nama }}</h3>
                    <p>Status: {{ $item->status }}</p>
                    <p>Jam Operasi: {{ $item->jam_buka }} - {{ $item->jam_tutup }}</p>

                    <div class="card-bottom">
                        <span class="price">
                            Rp {{ number_format($item->harga, 0, ',', '.') }} / Jam
                        </span>

                        <a href="{{ route('lapangan.edit', $item->id) }}" class="btn-edit">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada data lapangan</p>
        @endforelse
    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
