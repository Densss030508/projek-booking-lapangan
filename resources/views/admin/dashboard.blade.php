<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #dcdcdc;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #4f74c8, #3b63c5);
            height: 100vh;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px;
        }

        /* MENU */
        .menu a {
            display: block;
            padding: 10px;
            margin-bottom: 8px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu a.active {
            background: rgba(255, 255, 255, 0.3);
        }

        /* PROFILE */
        .profile {
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            padding-top: 15px;
        }

        .profile-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .profile-box img {
            width: 40px;
        }

        .logout-btn {
            background: red;
            border: none;
            padding: 8px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 14px;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 30px;
        }

        .title {
            font-size: 22px;
            margin-bottom: 25px;
        }

        /* STAT */
        .stats {
            display: flex;
            gap: 25px;
            margin-bottom: 25px;
        }

        .stat-card {
            flex: 1;
            padding: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 16px;
        }

        .stat-card h2 {
            font-size: 28px;
        }

        .blue {
            background: #7da3d7;
        }

        .green {
            background: #8be0a2;
        }

        .red {
            background: #ef7777;
        }

        /* CARD */
        .card {
            background: #efefef;
            padding: 20px;
        }

        .card h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #ddd;
        }

        /* STATUS */
        .status-active {
            background: #00ff00;
            padding: 3px 10px;
        }

        .status-non {
            background: red;
            color: white;
            padding: 3px 10px;
        }

        /* BUTTON */
        .btn-edit {
            background: #8be0a2;
            border: none;
            padding: 5px 12px;
            cursor: pointer;
        }
    </style>
</head>

<body>

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
                <a href="{{ route('laporan.index') }}">Laporan</a>
            </div>
        </div>

        <!-- PROFILE + LOGOUT -->
        <div class="profile">
            <div class="profile-box">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">
                <div>
                    <div>{{ ucfirst(auth()->user()->role ?? 'Admin') }}</div>
                    <small>{{ auth()->user()->nama ?? 'User' }}</small>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="title">Dashboard Admin</div>

        <!-- STAT -->
        <div class="stats">
            <div class="stat-card blue">
                <h2>{{ $totalUser }}</h2>
                <div>Total User</div>
            </div>

            <div class="stat-card green">
                <h2>{{ $totalLapangan }}</h2>
                <div>Total Lapangan</div>
            </div>

            <div class="stat-card red">
                <h2>{{ $nonAktif }}</h2>
                <div>Non Aktif Akun</div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <h3>Kelola Pengguna</h3>

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
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>

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
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
