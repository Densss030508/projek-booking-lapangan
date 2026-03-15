<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
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
            border-radius: 4px;
            cursor: pointer;
        }

        .status-active {
            background: #00ff40;
            padding: 4px 12px;
        }

        .status-non {
            background: red;
            color: white;
            padding: 4px 12px;
        }

        .btn-edit {
            background: #8be0a2;
            border: none;
            padding: 5px 14px;
            cursor: pointer;
        }

        /* HEADER */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h2 {
            font-size: 20px;
        }

        .btn-tambah {
            background: #4f73c7;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* GRID LAPANGAN */

        .lapangan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        /* CARD */

        .card {
            background: #efefef;
            padding: 15px;
            border-radius: 3px;
        }

        .card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .card-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .card-info {
            font-size: 12px;
            color: #666;
        }

        .card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .price {
            font-weight: 500;
        }

        .btn-edit {
            background: #4be37a;
            border: none;
            padding: 6px 18px;
            cursor: pointer;
        }

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
            padding: 6px 14px;
            border-radius: 20px;
            color: white;
            cursor: pointer;
        }

        /* MAIN */

        .main {
            flex: 1;
            padding: 30px;
        }

        /* TITLE */

        .title {
            font-size: 22px;
            margin-bottom: 25px;
        }

        /* CARD */

        .card {
            background: #efefef;
            padding: 20px;
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
    </style>

</head>

<body>

    <div class="sidebar">

        <div>

            <div class="logo">
                <img src="/images/kixa.png">
            </div>

            <div class="menu">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('lapangan.index') }}" class="{{ request()->routeIs('lapangan.*') ? 'active' : '' }}">
                    Kelola Lapangan
                </a>

                <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                    Kelola Pengguna
                </a>

                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    Laporan
                </a>
            </div>

        </div>

        <div class="profile">

            <div class="profile-box">

                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

                <div>
                    <div>Admin</div>
                    <small>Dahlan</small>
                </div>

            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">Log Out</button>
            </form>

        </div>

    </div>

    <div class="main">

        @yield('content')

    </div>

</body>

</html>
