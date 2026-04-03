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

        .btn-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-back,
        .btn-save {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-back {
            background: #6c757d;
        }

        .btn-save {
            background: #4f73c7;
        }

        .error-box {
            margin-bottom: 15px;
            background: #ffd2d2;
            color: red;
            padding: 10px;
            border-radius: 6px;
        }
    </style>

    <div class="btn-group">
        <h2>Tambah Pengguna</h2>
        <a href="{{ route('pengguna.index') }}" class="btn-back">← Kembali</a>
    </div>

    <div class="container-form">
        <form action="/admin/pengguna/store" method="POST">
            @csrf

            @if ($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama" value="{{ old('nama') }}">
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
                    <input type="email" name="email" value="{{ old('email') }}">
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

            <div style="display:flex; justify-content:flex-end; margin-top:25px;">
                <button type="submit" class="btn-save">+ Simpan Pengguna</button>
            </div>
        </form>
    </div>

@endsection
