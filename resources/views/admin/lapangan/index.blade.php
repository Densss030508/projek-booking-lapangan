<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna Admin</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #e9e9e9;
        }

        /* CONTAINER */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #4f73c7;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            text-align: center;
            padding: 20px;
        }

        .logo img {
            width: 80px;
        }

        /* MENU */
        .menu a {
            display: block;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        .menu a:hover {
            background: #3f60b1;
        }

        .menu .active {
            background: #d9d9d9;
            color: black;
        }

        /* PROFILE */
        .profile {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }

        .logout {
            margin-top: 10px;
            background: red;
            border: none;
            color: white;
            padding: 6px 18px;
            border-radius: 20px;
            cursor: pointer;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 40px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-tambah {
            background: #4f73c7;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* BOX TABLE */
        .table-container {
            background: #f4f4f4;
            padding: 25px;
            width: 900px;
            max-width: 100%;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 14px;
            border-bottom: 2px solid #888;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #bbb;
        }

        /* STATUS */
        .status-aktif {
            background: #00ff40;
            padding: 4px 14px;
            font-size: 13px;
        }

        .status-non {
            background: red;
            padding: 4px 14px;
            font-size: 13px;
        }

        /* BUTTON */
        .btn-edit {
            background: #80e693;
            border: none;
            padding: 6px 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div>

                <div class="logo">
                    <img src="/images/kixa.png">
                </div>

                <div class="menu">
                    <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>

                    <a href="{{ route('lapangan.index') }}">Kelola Lapangan</a>

                    <a href="{{ route('pengguna.index') }}">Kelola Pengguna</a>

                    <a href="#">Laporan</a>

                </div>

            </div>

            <div class="profile">
                <div>Admin</div>
                <div style="font-size:12px;">Dahlan</div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout">Log Out</button>
                </form>

            </div>

        </div>

        <!-- MAIN -->
        <div class="main">

            <div class="header">
                <h3>Kelola Pengguna Admin</h3>
                <button class="btn-tambah">+ Tambah Pengguna</button>
            </div>

            <div class="table-container">

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
                        <td>somat@gmail.com</td>
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
