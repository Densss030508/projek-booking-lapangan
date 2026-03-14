<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - KIXA Arena</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
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
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .logo {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .menu a {
            display: block;
            padding: 12px;
            margin-bottom: 12px;
            text-decoration: none;
            color: white;
            border-radius: 10px;
            transition: .3s;
        }

        .menu a.active,
        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu form {
            margin-top: 10px;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            padding: 12px;
            width: 100%;
            text-align: left;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            transition: .3s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* ================= MAIN ================= */
        .main {
            margin-left: 260px;
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

        /* ================= STAT CARD ================= */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            color: white;
            padding: 25px;
            border-radius: 15px;
        }

        .stat-card h2 {
            font-size: 28px;
        }

        .blue {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
        }

        .green {
            background: linear-gradient(135deg, #22c55e, #15803d);
        }

        .orange {
            background: linear-gradient(135deg, #fb923c, #ea580c);
        }

        .red {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        /* ================= CARD ================= */
        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        /* ================= TABLE ================= */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        thead {
            background: #f1f5f9;
        }

        tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: white;
        }

        .badge-success {
            background: #22c55e;
        }

        .badge-danger {
            background: #ef4444;
        }

        .btn {
            padding: 6px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            color: white;
        }

        .btn-edit {
            background: #22c55e;
        }

        .btn-delete {
            background: #ef4444;
        }

        .btn-primary {
            background: #2563eb;
            padding: 8px 16px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">⚽ KIXA Arena</div>

        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('lapangan.index') }}" class="{{ request()->routeIs('lapangan.*') ? 'active' : '' }}">
                Kelola Lapangan
            </a>

            <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                Kelola Pengguna
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h2>Dashboard Admin</h2>
            <div class="profile">
                <img src="https://i.pravatar.cc/40" alt="">
                <span>Admin</span>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card blue">
                <h2>150</h2>
                <p>Total User</p>
            </div>

            <div class="stat-card green">
                <h2>6</h2>
                <p>Total Lapangan</p>
            </div>

            <div class="stat-card orange">
                <h2>8</h2>
                <p>Sedang Booking</p>
            </div>

            <div class="stat-card red">
                <h2>1</h2>
                <p>Lapangan Nonaktif</p>
            </div>
        </div>

        <div class="card">
            <h3>Statistik Booking Mingguan</h3>
            <canvas id="bookingChart" height="100"></canvas>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('bookingChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                datasets: [{
                    data: [11, 13, 23, 19, 16, 10],
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>
