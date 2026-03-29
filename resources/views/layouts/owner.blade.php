<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        .filter-box {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-box input,
        .filter-box select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table img {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #a7d3df;
            padding: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        .badge {
            background: #4ade80;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .btn-blue {
            background: #4f74c8;
            color: white;
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
        .page-title {
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* CARD BOX */
        .card-box {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* CARD */
        .card {
            flex: 1;
            padding: 15px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: #000;
        }

        .card i {
            font-size: 22px;
        }

        .card h2 {
            margin: 0;
            font-size: 18px;
        }

        .card p {
            margin: 0;
            font-size: 12px;
        }

        /* WARNA CARD */
        .blue {
            background: #7ea6e0;
        }

        .green {
            background: #7be0a4;
        }

        .orange {
            background: #f4b183;
        }

        .red {
            background: #f28b82;
        }

        /* BOX PUTIH */
        .box {
            background: #ffffff;
            padding: 20px;
            border-radius: 6px;
        }

        /* CHART */
        .chart {
            height: 300px;
            background: #f7f7f7;
            border-radius: 6px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
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
                <a href="{{ route('owner.dashboard') }}"
                    class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('owner.produk') }}" class="{{ request()->routeIs('owner.produk') ? 'active' : '' }}">
                    Data Produk
                </a>

                <a href="{{ route('owner.laporan') }}"
                    class="{{ request()->routeIs('owner.laporan') ? 'active' : '' }}">
                    Laporan Transaksi
                </a>

                <a href="{{ route('owner.aktivitas') }}"
                    class="{{ request()->routeIs('owner.aktivitas') ? 'active' : '' }}">
                    Log Aktivitas
                </a>
            </div>

        </div>

        <div class="profile">

            <div class="profile-box">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

                <div>
                    <div>Owner</div>
                    <small>{{ Auth::user()->nama ?? 'User' }}</small>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
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
