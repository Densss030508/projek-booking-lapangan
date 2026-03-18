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

        .form-group input,
        .form-group select {
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

        <form id="updateForm" action="{{ route('pengguna.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama" value="{{ $user->nama ?? '' }}">
                </div>

                <div class="form-group">
                    <label>Peran</label>
                    <div class="form-disabled">
                        Tidak Bisa Di Ubah Ketika Di Edit
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation">
                </div>

            </div>

            @if (session('success'))
                <div class="success-box">
                    ✔ Lapangan Telah Berhasil Di Perbarui
                </div>
            @endif

            <div style="display: flex; justify-content: space-between;">
                <button type="button" onclick="confirmDelete()" class="btn btn-delete">Hapus Pengguna</button>
                <button type="button" onclick="confirmUpdate()" class="btn btn-save">+ Simpan Pengguna</button>
            </div>

        </form>

        <!-- FORM DELETE (TAMBAHAN) -->
        <form id="deleteForm" action="{{ route('pengguna.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Perubahan data akan disimpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updateForm').submit();
                }
            })
        }

        function confirmDelete() {
            Swal.fire({
                title: 'Yakin hapus pengguna?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            })
        }
    </script>

@endsection
