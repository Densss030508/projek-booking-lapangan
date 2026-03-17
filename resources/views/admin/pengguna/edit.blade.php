@extends('layouts.admin')

@section('title', 'Edit Pengguna')

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

        .form-group input {
            padding: 10px;
            background: #ddd;
            border: none;
            border-radius: 4px;
        }

        .form-disabled {
            padding: 10px;
            background: #ccc;
            border-radius: 4px;
            text-align: center;
            font-size: 13px;
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

        .btn-delete {
            background: #ff6b6b;
            color: white;
            margin-top: 20px;
        }
    </style>

    <div class="header">
        <h2>Kelola Pengguna</h2>
        <a href="{{ route('pengguna.index') }}" class="btn btn-back">← Kembali</a>
    </div>

    <div class="container-form">

        <h3>Edit Pengguna</h3>

        <form action="#" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- Nama -->
                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama" value="{{ $user->nama ?? '' }}">
                </div>

                <!-- Role (tidak bisa diubah) -->
                <div class="form-group">
                    <label>Peran</label>
                    <div class="form-disabled">
                        Tidak Bisa Di Ubah Ketika Di Edit
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}">
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" value="{{ $user->status ?? '' }}">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password">
                </div>

                <!-- Konfirmasi -->
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation">
                </div>

            </div>

            <div class="success-box">
                ✔ Lapangan Telah Berhasil Di Perbarui
            </div>

            <div style="display: flex; justify-content: space-between;">
                <button type="button" class="btn btn-delete">Hapus Pengguna</button>
                <button type="submit" class="btn btn-save">+ Simpan Pengguna</button>
            </div>

        </form>

    </div>

@endsection
