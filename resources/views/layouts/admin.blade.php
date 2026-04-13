<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

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
            position: fixed;
            top: 0;
            left: 0;
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

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.2);
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
            height: 40px;
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
            margin-left: 230px;
            padding: 30px;
            min-height: 100vh;
        }

        /* GLOBAL CARD */
        .card {
            background: #efefef;
            padding: 20px;
            border-radius: 8px;
        }

        /* GLOBAL TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f1f1f1;
        }

        /* STATUS */
        .status-active {
            background: #2ecc71;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .status-non {
            background: #e74c3c;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
        }

        /* BUTTON */
        .btn-edit {
            background: #2ecc71;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-tambah {
            background: #4f73c7;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
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
                    <div>{{ ucfirst(auth()->user()->role ?? 'Admin') }}</div>
                    <small>{{ auth()->user()->nama ?? 'User' }}</small>
                </div>
            </div>

            <!--  SWEETALERT TARGET -->
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="main">
        @yield('content')
    </div>

    <!--  SWEETALERT CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--  SWEETALERT SCRIPT -->
    <script>
        const logoutForm = document.querySelector('.logout-form');

        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: "Session Anda akan diakhiri dari sistem.",
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
