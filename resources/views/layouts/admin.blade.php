<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - KIXA Arena</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background: #f4f6fb;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3a8a, #2563eb);
            color: white;
            padding: 25px 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .logo {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .menu a {
            display: block;
            padding: 12px 15px;
            margin-bottom: 12px;
            text-decoration: none;
            color: white;
            border-radius: 10px;
            transition: 0.3s;
        }

        .menu a.active,
        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu button {
            background: none;
            border: none;
            color: white;
            margin-top: 10px;
            cursor: pointer;
            padding: 12px 15px;
        }

        /* ================= MAIN ================= */
        .main {
            margin-left: 260px;
            flex: 1;
            padding: 30px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile {
            background: white;
            padding: 8px 15px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        /* ================= TOP BAR BUTTON ================= */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        /* ================= GRID ================= */
        .lapangan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        /* ================= CARD ================= */
        .lapangan-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .lapangan-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .lapangan-content {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lapangan-content h3 {
            font-size: 20px;
            margin-bottom: 6px;
        }

        .lapangan-content p {
            color: #555;
        }

        .btn-success {
            background: linear-gradient(135deg, #22c55e, #15803d);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">⚽ KIXA Arena</div>

        <div class="menu">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

            <a href="{{ route('lapangan.index') }}"
                class="{{ request()->routeIs('lapangan.*') ? 'active' : '' }}">Kelola Lapangan</a>

            <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                Kelola Pengguna
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h2>@yield('title')</h2>

            <div class="profile">
                <img src="https://i.pravatar.cc/40">
                <span>Admin</span>
            </div>
        </div>

        @yield('content')

    </div>

</body>

</html>
