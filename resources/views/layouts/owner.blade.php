<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        }

        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #4f74c8, #3b63c5);
            height: 100vh;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px;
        }

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

        .main {
            margin-left: 230px;
            flex: 1;
            padding: 30px;
            min-height: 100vh;
            background: #dcdcdc;
        }

        .page-title {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .card-box {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

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

        .box {
            background: #ffffff;
            padding: 20px;
            border-radius: 6px;
        }

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

                <script>
                    function logSidebar(activity) {
                        fetch("{{ route('log.sidebar') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                activity: activity
                            })
                        });
                    }
                </script>

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
                    <p>{{ ucfirst(auth()->user()->role ?? 'Owner') }}</p>
                    <small>{{ auth()->user()->nama ?? 'User' }}</small>
                </div>
            </div>

            <!-- ✅ tetap form lama, hanya diganti jadi reusable -->
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Log Out</button>
            </form>

        </div>

    </div>

    <div class="main">
        @yield('content')
    </div>

    <!-- ✅ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const logoutForm = document.querySelector('.logout-form');

        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: "Session owner akan diakhiri.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        logoutForm.submit();
                    }
                });
            });
        }
    </script>

</body>

</html>
