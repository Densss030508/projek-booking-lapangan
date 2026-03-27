<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            background: #4da3b8;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: linear-gradient(#4e73df, #3fa7c4);
            color: white;
            height: 100vh;
            padding: 20px;
        }

        .sidebar img {
            width: 80px;
            display: block;
            margin: auto;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 6px;
        }

        /* PROFILE */
        .profile {
            margin-top: 50px;
            text-align: center;
        }

        .profile img {
            width: 50px;
        }

        .logout {
            background: red;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 15px;
        }

        /* CONTENT */
        .content {
            flex: 1;
            background: #eaeaea;
            padding: 20px;
        }

        /* CARD BOX */
        .card-box {
            display: flex;
            gap: 10px;
        }

        .card {
            flex: 1;
            padding: 15px;
            border-radius: 6px;
            color: black;
        }

        .blue {
            background: #7fb3ff;
        }

        .green {
            background: #7be0a4;
        }

        .orange {
            background: #ffc48c;
        }

        .red {
            background: #ff8c8c;
        }

        /* BOX */
        .box {
            background: white;
            padding: 20px;
            margin-top: 20px;
        }

        /* TABLE */
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
        }

        .badge {
            background: #7be0a4;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* BUTTON */
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .btn-blue {
            background: #6fa8dc;
            color: white;
        }

        .btn-green {
            background: #4ade80;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <img src="https://via.placeholder.com/80">

        <a href="{{ route('owner.dashboard') }}">Dashboard</a>
        <a href="{{ route('owner.produk') }}" class="active">Data Produk</a>
        <a href="{{ route('owner.laporan') }}">Laporan Transaksi</a>
        <a href="{{ route('owner.aktivitas') }}">Log Aktivitas</a>

        <div class="profile">
            <p>Owner</p>
            <small>Dahlan</small><br><br>
            <button class="logout">Log Out</button>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>

</html>
