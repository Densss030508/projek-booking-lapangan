<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna Admin</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #e6e6e6;
        }

        /* LAYOUT */
        .container {
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #4f6fc9;
            color: white;
            height: 100vh;
            position: relative;
        }

        .logo {
            text-align: center;
            padding: 20px;
        }

        .menu a {
            display: block;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
        }

        .menu a:hover {
            background: #3e5fb0;
        }

        .active {
            background: #dcdcdc;
            color: black;
        }

        /* PROFILE */
        .profile {
            position: absolute;
            bottom: 30px;
            left: 20px;
        }

        .logout {
            margin-top: 8px;
            background: red;
            border: none;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-tambah {
            background: #4f6fc9;
            color: white;
            border: none;
            padding: 8px 15px;
        }

        /* TABLE */
        .table-box {
            margin-top: 20px;
            background: #f3f3f3;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #999;
        }

        .status-aktif {
            background: #2ee04f;
            padding: 3px 10px;
        }

        .status-non {
            background: red;
            color: black;
            padding: 3px 10px;
        }

        .btn-edit {
            background: #7be48c;
            border: none;
            padding: 5px 15px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div class="logo">
                <img src="logo.png" width="70">
            </div>

            <div class="menu">
                <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>

                <a href="{{ route('lapangan.index') }}">Kelola Lapangan</a>

                <a href="{{ route('pengguna.index') }}">Kelola Pengguna</a>

                <a href="#">Laporan</a>

            </div>

            <div class="profile">
                <div>Admin</div>
                <div style="font-size:12px;">Dahlan</div>
                <button class="logout">Log Out</button>
            </div>

        </div>

        <!-- MAIN -->
        <div class="main">

            <div class="header">
                <h3>Kelola Pengguna Admin</h3>
                <button class="btn-tambah">+ Tambah Pengguna</button>
            </div>

            <div class="table-box">

                <table>

                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                    <tr>
                        <td>Dahlan Kasir</td>
                        <td>dashlan@gmail.com</td>
                        <td>Kasir</td>
                        <td><span class="status-aktif">Aktif</span></td>
                        <td><button class="btn-edit">Edit</button></td>
                    </tr>

                    <tr>
                        <td>Asep Admin</td>
                        <td>asep@gmail.com</td>
                        <td>Admin</td>
                        <td><span class="status-aktif">Aktif</span></td>
                        <td><button class="btn-edit">Edit</button></td>
                    </tr>

                    <tr>
                        <td>Somat Owner</td>
                        <td>Somat@gmail.com</td>
                        <td>Owner</td>
                        <td><span class="status-aktif">Aktif</span></td>
                        <td><button class="btn-edit">Edit</button></td>
                    </tr>

                    <tr>
                        <td>Kasim Kasir</td>
                        <td>kasim@gmail.com</td>
                        <td>Kasir</td>
                        <td><span class="status-non">Di NonAktifkan</span></td>
                        <td><button class="btn-edit">Edit</button></td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</body>

</html>
```
