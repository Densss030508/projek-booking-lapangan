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
            color: #555;
        }

        .btn-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-action {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            gap: 10px;
        }

        .btn-back,
        .btn-save,
        .btn-delete {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-back {
            background: #6c757d;
        }

        .btn-save {
            background: #4f73c7;
        }

        .btn-delete {
            background: #e74c3c;
        }

        /* ✅ NOTIFIKASI */
        .success-box {
            background: #2ecc71;
            color: white;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-box {
            background: #e74c3c;
            color: white;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>

    <div class="btn-top">
        <h2>Edit Pengguna</h2>
        <a href="{{ route('pengguna.index') }}" class="btn-back">← Kembali</a>
    </div>

    {{-- ✅ NOTIF BERHASIL --}}
    @if (session('success'))
        <div class="success-box">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ✅ NOTIF ERROR --}}
    @if (session('error'))
        <div class="error-box">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="container-form">
        <form id="updateForm" action="{{ route('pengguna.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama" value="{{ $user->nama }}">
                </div>

                <div class="form-group">
                    <label>Peran</label>
                    <div class="form-disabled">{{ ucfirst($user->role) }}</div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <div class="form-disabled">
                        @if ($user->role == 'owner')
                            🔒 Owner selalu aktif
                        @else
                            {{ $user->status == 'aktif' ? '✅ Aktif' : '❌ Nonaktif' }}
                        @endif
                    </div>
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

            <div class="btn-action">
                @if ($user->role != 'owner')
                    <button type="button" onclick="confirmDelete()" class="btn-delete">
                        Hapus Pengguna
                    </button>
                @else
                    <button type="button" class="btn-delete" style="background:#95a5a6; cursor:not-allowed;">
                        🔒 Owner Tidak Bisa Dihapus
                    </button>
                @endif

                <button type="button" onclick="confirmUpdate()" class="btn-save">
                    + Simpan Pengguna
                </button>
            </div>
        </form>

        @if ($user->role != 'owner')
            <form id="deleteForm" action="{{ route('pengguna.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>

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
