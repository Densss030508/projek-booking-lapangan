<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #4aa3b5;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: linear-gradient(#4e73df, #224abe);
            color: white;

            /* 🔥 FIX SIDEBAR DIAM */
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            flex-shrink: 0;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .top {
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 70px;
        }

        .menu a {
            display: block;
            padding: 12px;
            margin-bottom: 8px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu a.active {
            background: rgba(255, 255, 255, 0.3);
        }

        /* BOTTOM */
        .bottom {
            padding: 20px;
            text-align: center;
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

        /* CONTENT */
        .content {
            /* 🔥 FIX GESER KANAN SESUAI LEBAR SIDEBAR */
            margin-left: 230px;
            flex: 1;
            background: #e5e5e5;
            padding: 20px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div class="top">

                <div class="logo">
                    <img src="{{ asset('images/kixa.png') }}" alt="Logo">
                </div>

                <div class="menu">
                    <a href="{{ route('kasir.dashboard') }}"
                        class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('kasir.jadwal') }}"
                        class="{{ request()->routeIs('kasir.jadwal') ? 'active' : '' }}">
                        Jadwal Lapangan
                    </a>

                    <a href="{{ route('kasir.transaksi') }}"
                        class="{{ request()->routeIs('kasir.transaksi') ? 'active' : '' }}">
                        Transaksi
                    </a>

                    <a href="{{ route('kasir.booking') }}"
                        class="{{ request()->routeIs('kasir.booking') ? 'active' : '' }}">
                        Booking Lapang
                    </a>
                </div>

            </div>

            <div class="bottom">
                <p>{{ ucfirst(auth()->user()->role ?? 'Kasir') }}</p>
                <small>{{ auth()->user()->nama ?? 'User' }}</small>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn">Log Out</button>
                </form>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>

</body>

</html>
