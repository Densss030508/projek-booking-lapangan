<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #5fa8b8;
        }

        .container {
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #4f73c3;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
        }

        .menu a {
            display: block;
            color: white;
            padding: 10px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .active {
            background: #6c8fe0;
        }

        .logout {
            margin-top: 50px;
            text-align: center;
        }

        .logout button {
            background: red;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
        }

        /* CONTENT */
        .content {
            flex: 1;
            background: #ddd;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <div class="sidebar">
            <h2>KASIR</h2>

            <div class="menu">
                <a href="{{ route('kasir.dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('kasir.jadwal') }}">Jadwal Lapangan</a>
                <a href="{{ route('kasir.transaksi') }}">Transaksi</a>
                <a href="{{ route('kasir.booking') }}">Booking Lapang</a>
            </div>

            <div class="logout">
                <p>Kasir</p>
                <button>Log Out</button>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>

</body>

</html>
