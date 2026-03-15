@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    <div class="header">
        <h2>Kelola Pengguna Admin</h2>
        <button class="btn-tambah">+ Tambah Pengguna</button>
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

                <tr>
                    <td>Dahlan Kasir</td>
                    <td>dahlan@gmail.com</td>
                    <td>Kasir</td>
                    <td><span class="status-active">Aktif</span></td>
                    <td><button class="btn-edit">Edit</button></td>
                </tr>

                <tr>
                    <td>Asep Admin</td>
                    <td>asep@gmail.com</td>
                    <td>Admin</td>
                    <td><span class="status-active">Aktif</span></td>
                    <td><button class="btn-edit">Edit</button></td>
                </tr>

                <tr>
                    <td>Somat Owner</td>
                    <td>somat@gmail.com</td>
                    <td>Owner</td>
                    <td><span class="status-active">Aktif</span></td>
                    <td><button class="btn-edit">Edit</button></td>
                </tr>

                <tr>
                    <td>Kasim Kasir</td>
                    <td>kasim@gmail.com</td>
                    <td>Kasir</td>
                    <td><span class="status-non">Di NonAktifkan</span></td>
                    <td><button class="btn-edit">Edit</button></td>
                </tr>

            </tbody>

        </table>

    </div>

@endsection
