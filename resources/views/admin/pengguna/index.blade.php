@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    <div class="header">
        <h2>Kelola Pengguna Admin</h2>
        <a href="{{ route('pengguna.create') }}" class="btn-tambah">+ Tambah Pengguna</a>
    </div>

    {{-- Notifikasi sukses/error --}}
    @if (session('success'))
        <div style="background:#2ecc71; color:white; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="background:#e74c3c; color:white; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @if ($user->status == 'aktif')
                                <span class="status-active">Aktif</span>
                            @else
                                <span class="status-non">Di NonAktifkan</span>
                            @endif
                        </td>
                        <td style="display:flex; gap:8px; align-items:center;">

                            {{-- Tombol Edit (hanya jika aktif) --}}
                            @if ($user->status === 'aktif')
                                <a href="{{ route('pengguna.edit', $user->id) }}" class="btn-edit">Edit</a>
                            @endif

                            {{-- Tombol Aktifkan / Nonaktifkan (tidak tampil untuk diri sendiri) --}}
                            @if (Auth::id() != $user->id)
                                <form id="form-toggle-{{ $user->id }}"
                                    action="{{ route('pengguna.toggleStatus', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button"
                                        onclick="konfirmasiToggle(
                                            '{{ $user->id }}',
                                            '{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}',
                                            '{{ $user->nama }}'
                                        )"
                                        style="
                                            padding: 5px 10px;
                                            border: none;
                                            border-radius: 5px;
                                            cursor: pointer;
                                            color: white;
                                            background: {{ $user->status === 'aktif' ? '#e74c3c' : '#2ecc71' }};
                                        ">
                                        {{ $user->status === 'aktif' ? '⛔ Nonaktifkan' : '✅ Aktifkan' }}
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiToggle(id, aksi, nama) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: aksi + ' user ' + nama + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: aksi === 'Nonaktifkan' ? '#e74c3c' : '#2ecc71',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, ' + aksi + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-toggle-' + id).submit();
                }
            });
        }
    </script>

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
