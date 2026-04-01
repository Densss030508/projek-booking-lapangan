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
            text-decoration: none;
            font-size: 13px;
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

        .card-nonaktif {
            opacity: 0.6;
            border: 2px solid #e74c3c;
        }
    </style>

    <!-- HEADER -->
    <div class="header">
        <h2>Kelola Lapangan Admin</h2>
        <a href="{{ route('lapangan.create') }}" class="btn-tambah">+ Tambah Lapangan</a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div style="background:#2ecc71; color:white; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- GRID -->
    <div class="lapangan-grid">
        @forelse ($lapangan as $item)
            <div class="card {{ $item->status === 'nonaktif' ? 'card-nonaktif' : '' }}">

                <img src="{{ asset('storage/' . $item->foto) }}" alt="foto">

                {{-- Banner nonaktif --}}
                @if ($item->status === 'nonaktif')
                    <div
                        style="background:#e74c3c; color:white; text-align:center; padding:4px; font-size:12px; margin-top:6px; border-radius:4px;">
                        ⛔ Lapangan Nonaktif
                    </div>
                @endif

                <div class="card-body">
                    <h3>{{ $item->nama }}</h3>
                    <p>Status:
                        @if ($item->status === 'nonaktif')
                            <span style="color:#e74c3c; font-weight:bold;">⛔ Nonaktif</span>
                        @elseif ($item->status === 'tersedia')
                            <span style="color:#2ecc71; font-weight:bold;">✅ Tersedia</span>
                        @else
                            <span style="color:#f39c12; font-weight:bold;">⏳ Tidak Tersedia</span>
                        @endif
                    </p>
                    <p>Jam Operasi: {{ $item->jam_buka }} - {{ $item->jam_tutup }}</p>

                    <div class="card-bottom">
                        <span class="price">
                            Rp {{ number_format($item->harga, 0, ',', '.') }} / Jam
                        </span>

                        <div style="display:flex; gap:8px; align-items:center;">

                            {{-- Tombol Edit (hanya jika tidak nonaktif) --}}
                            @if ($item->status !== 'nonaktif')
                                <a href="{{ route('lapangan.edit', $item->id) }}" class="btn-edit">Edit</a>
                            @endif

                            {{-- Tombol Aktifkan / Nonaktifkan --}}
                            <form action="{{ route('lapangan.toggleActive', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('{{ $item->status === 'nonaktif' ? 'Aktifkan kembali' : 'Nonaktifkan' }} lapangan {{ $item->nama }}?')"
                                    style="
                                        padding: 6px 12px;
                                        border: none;
                                        border-radius: 6px;
                                        cursor: pointer;
                                        color: white;
                                        font-size: 13px;
                                        background: {{ $item->status === 'nonaktif' ? '#2ecc71' : '#e74c3c' }};
                                    ">
                                    {{ $item->status === 'nonaktif' ? '✅ Aktifkan' : '⛔ Nonaktifkan' }}
                                </button>
                            </form>

                        </div>
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
