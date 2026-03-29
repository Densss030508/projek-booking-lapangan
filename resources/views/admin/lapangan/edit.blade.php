@extends('layouts.admin')

@section('title', 'Edit Lapangan')

@section('content')

    <style>
        .container-box {
            background: #eaeaea;
            padding: 20px;
            border-radius: 5px;
        }

        .form-box {
            background: #f5f5f5;
            padding: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: none;
            background: #dcdcdc;
        }

        .btn-simpan {
            background: #4f73c7;
            color: white;
            border: none;
            padding: 8px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-kembali {
            float: right;
            background: #4f73c7;
            color: white;
            padding: 5px 15px;
            text-decoration: none;
            border-radius: 3px;
        }

        .preview-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            margin-top: 10px;
        }
    </style>

    <div class="container-box">

        <div class="header">
            <h3>Kelola Lapangan</h3>
            <a href="{{ route('lapangan.index') }}" class="btn-kembali">← Kembali</a>
        </div>

        <div class="form-box">
            <h4>Edit Lapangan</h4>

            <form action="{{ route('lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <!-- KIRI -->
                    <div>
                        <div class="form-group">
                            <label>Nama Lapangan</label>
                            <input type="text" name="nama" value="{{ $lapangan->nama }}">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="tersedia" {{ $lapangan->status == 'tersedia' ? 'selected' : '' }}>Tersedia
                                </option>
                                <option value="tidak tersedia"
                                    {{ $lapangan->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jam Buka</label>
                            <input type="time" name="jam_buka" value="{{ $lapangan->jam_buka }}">
                        </div>

                        <div class="form-group">
                            <label>Jam Tutup</label>
                            <input type="time" name="jam_tutup" value="{{ $lapangan->jam_tutup }}">
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div>
                        <div class="form-group">
                            <label>Harga Per Jam</label>
                            <input type="number" name="harga" value="{{ $lapangan->harga }}">
                        </div>

                        <div class="form-group">
                            <label>Foto Lapangan</label>
                            <input type="file" name="foto">
                            <img src="{{ asset('storage/' . $lapangan->foto) }}" class="preview-img">
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn-simpan">Update Lapangan</button>

            </form>
        </div>

    </div>

@endsection
