@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

    <style>
        .container-form {
            background: #f5f5f5;
            padding: 30px;
            border-radius: 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            padding: 10px;
            background: #ddd;
            border: none;
            border-radius: 4px;
        }

        .success-box {
            margin-top: 20px;
            background: #c8f7c5;
            color: green;
            padding: 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            background: #5b7bd5;
            color: white;
        }

        .btn-save {
            background: #5b7bd5;
            color: white;
            float: right;
            margin-top: 20px;
        }
    </style>

    <div class="header">
        <h2>Kelola Pengguna</h2>
        <a href="{{ route('pengguna.index') }}" class="btn btn-back">← Kembali</a>
    </div>

    <div class="container-form">

        <h3>Tambah Pengguna</h3>

        <form action="#" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama">
                </div>

                <div class="form-group">
                    <label>Peran</label>
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation">
                </div>

            </div>

            <div class="success-box">
                ✔ Lapangan Telah Berhasil Di Tambah
            </div>

            <button type="submit" class="btn btn-save">+ Simpan Pengguna</button>

        </form>

    </div>

@endsection
