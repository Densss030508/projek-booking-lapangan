<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>KIXA Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF TOKEN (PENTING) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        /* 🔥 ERROR BOX BARU */
        .error-box {
            background: rgba(255, 82, 82, 0.15);
            color: #ff5252;
            border: 1px solid #ff5252;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
            animation: shake 0.3s;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-3px);
            }

            50% {
                transform: translateX(3px);
            }

            75% {
                transform: translateX(-3px);
            }

            100% {
                transform: translateX(0);
            }
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

    <!-- LOGIN MODAL -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- BACKUP TOKEN -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <h2>Login KIXA</h2>

                <!-- 🔥 ERROR TAMPILAN BARU -->
                @if ($errors->any())
                    <div class="error-box">
                        ❌ {{ $errors->first() }}
                    </div>
                @endif

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
