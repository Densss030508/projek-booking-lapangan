@extends('layouts.admin')

@section('content')
    <style>
        .container {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: none;
            background: #ddd;
            border-radius: 5px;
        }

        .preview {
            width: 100%;
            height: 150px;
            background: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            overflow: hidden;
        }

        .preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn {
            background: #5c6bc0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back {
            background: #5c6bc0;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .success-box {
            background: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
        }

        .footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h3>Tambah Lapangan</h3>
            <a href="{{ route('lapangan.index') }}" class="btn-back">← Kembali</a>
        </div>

        <form action="{{ route('lapangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">

                <!-- KIRI -->
                <div>
                    <label>Nama Lapangan</label>
                    <input type="text" name="nama" required>

                    <label>Status</label>
                    <select name="status">
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>

                    <label>Jam Operasi</label>
                    <input type="time" name="jam_buka">
                    <input type="time" name="jam_tutup">

                    <label>Jenis Lapangan</label>
                    <input type="text" name="jenis" placeholder="Contoh: Sintetis / Vinyl">
                </div>

                <!-- KANAN -->
                <div>
                    <label>Harga Per Jam</label>
                    <input type="number" name="harga" required>

                    <label>Foto Lapangan</label>
                    <input type="file" name="foto" onchange="previewImage(event)" required>

                    <div class="preview">
                        <img id="preview-img" src="" alt="Preview">
                    </div>
                </div>

            </div>

            <!-- SUCCESS -->
            @if (session('success'))
                <div class="success-box">
                    ✔ Lapangan Telah Berhasil Di Simpan
                </div>
            @endif

            <!-- BUTTON -->
            <div class="footer">
                <button type="submit" class="btn">+ Simpan Lapangan</button>
            </div>

        </form>

    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
