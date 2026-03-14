@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    <div style="display:flex;justify-content:flex-end;margin-bottom:20px;">
        <button class="btn btn-primary" style="display:flex;align-items:center;gap:8px;">
            + Tambah Pengguna
        </button>
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
                    <td><strong>Budi Kasir</strong></td>
                    <td>budi@gmail.com</td>
                    <td>Kasir</td>
                    <td>
                        <span style="background:#15803d;color:white;padding:6px 15px;border-radius:20px;font-size:13px;">
                            Aktif
                        </span>
                    </td>
                    <td style="display:flex;align-items:center;gap:10px;">
                        <button class="btn btn-success">Edit</button>
                        <button class="btn btn-danger">Nonaktifkan</button>
                        <span style="font-size:20px;color:#9ca3af;cursor:pointer;">•••</span>
                    </td>
                </tr>

                <tr>
                    <td><strong>Dewi Owner</strong></td>
                    <td>dewi@gmail.com</td>
                    <td>Owner</td>
                    <td>
                        <span style="background:#15803d;color:white;padding:6px 15px;border-radius:20px;font-size:13px;">
                            Aktif
                        </span>
                    </td>
                    <td style="display:flex;align-items:center;gap:10px;">
                        <button class="btn btn-success" style="background:#e5e7eb;color:#374151;">Edit</button>
                        <span style="font-size:20px;color:#9ca3af;cursor:pointer;">•••</span>
                    </td>
                </tr>

                <tr>
                    <td><strong>Agus Admin</strong></td>
                    <td>agus@gmail.com</td>
                    <td>Admin</td>
                    <td>
                        <span style="background:#15803d;color:white;padding:6px 15px;border-radius:20px;font-size:13px;">
                            Aktif
                        </span>
                    </td>
                    <td style="display:flex;align-items:center;gap:10px;">
                        <button class="btn btn-success" style="background:#e5e7eb;color:#374151;">Edit</button>
                        <span style="font-size:20px;color:#9ca3af;cursor:pointer;">•••</span>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

@endsection
