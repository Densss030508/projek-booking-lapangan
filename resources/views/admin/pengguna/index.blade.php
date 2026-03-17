@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    <div class="header">
        <h2>Kelola Pengguna Admin</h2>
        <a href="{{ route('pengguna.create') }}" class="btn-tambah">+ Tambah Pengguna</a>
    </div>

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

                {{-- DATA DARI DATABASE --}}
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
                        <td>
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn-edit">Edit</a>
                        </td>
                    </tr>
                @endforeach

                {{-- DATA DUMMY (TETAP ADA SESUAI PERMINTAANMU) --}}

            </tbody>

        </table>

    </div>

@endsection
