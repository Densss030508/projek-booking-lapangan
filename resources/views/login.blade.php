<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>KIXA Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #081b33;
            color: white;
        }

        .navbar {
            position: fixed;
            width: 100%;
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(8, 27, 51, 0.95);
            z-index: 100;
        }

        .logo-area img {
            height: 50px;
            filter: drop-shadow(0 0 8px rgba(0, 229, 255, 0.6));
        }

        .login-btn {
            padding: 8px 20px;
            border-radius: 20px;
            border: 2px solid #00e5ff;
            color: #00e5ff;
            background: transparent;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #00e5ff;
            color: #081b33;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1556056504-5c7696c4c28d');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 60px;
            background: linear-gradient(45deg, #00e5ff, #00e676);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info-section {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 80px 8%;
            flex-wrap: wrap;
        }

        .card {
            background: #102a4d;
            width: 280px;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 229, 255, 0.15);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #00e5ff;
        }

        .card p {
            font-size: 14px;
            color: #ccc;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            background: #102a4d;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            position: relative;
        }

        .modal-content h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00e5ff;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border-radius: 20px;
            border: none;
            background: linear-gradient(45deg, #00e676, #00c853);
            font-weight: bold;
            cursor: pointer;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="logo-area">
            <img src="{{ asset('images/kixa.png') }}" alt="KIXA Logo">
        </div>
        <button class="login-btn" onclick="openModal()">Login</button>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div>
            <h1>Welcome to KIXA Arena</h1>
            <p>Booking Lapangan Futsal Modern & Profesional</p>
        </div>
    </section>

    <!-- INFO -->
    <section class="info-section">
        <div class="card">
            <h3>Lapangan Sintetis</h3>
            <p>Rumput sintetis kualitas premium standar nasional dengan pencahayaan LED terang.</p>
        </div>

        <div class="card">
            <h3>Ruang Ganti</h3>
            <p>Ruang ganti bersih dan nyaman dengan fasilitas loker dan shower.</p>
        </div>

        <div class="card">
            <h3>Parkir Luas</h3>
            <p>Area parkir luas dan aman untuk motor maupun mobil.</p>
        </div>
    </section>

    <!-- LOGIN MODAL -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Login KIXA</h2>

                @if ($errors->any())
                    <div style="color:#ff5252;text-align:center;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- SUDAH PAKAI USERNAME -->
                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>

                <input type="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>
            </form>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("loginModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("loginModal").style.display = "none";
        }
    </script>

</body>

</html>
