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
        }

        .login-btn {
            padding: 8px 20px;
            border-radius: 20px;
            border: 2px solid #00e5ff;
            color: #00e5ff;
            background: transparent;
            cursor: pointer;
            font-weight: bold;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1556056504-5c7696c4c28d');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 50px;
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
        }

        .modal-content {
            background: #102a4d;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #00e676;
            border: none;
            cursor: pointer;
        }

        .error-box {
            background: #ff5252;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo-area">
            <img src="{{ asset('images/kixa.png') }}">
        </div>
        <button class="login-btn" onclick="openModal()">Login</button>
    </div>

    <section class="hero">
        <div>
            <h1>Welcome to KIXA Arena</h1>
        </div>
    </section>

    <div class="modal" id="loginModal" style="display: {{ $errors->any() ? 'flex' : 'none' }};">
        <div class="modal-content">

            <form method="POST" action="/login">
                @csrf

                <h2>Login</h2>

                @if ($errors->any())
                    <div class="error-box">
                        {{ $errors->first() }}
                    </div>
                @endif

                <input type="text" name="username" placeholder="Username / Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>
            </form>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("loginModal").style.display = "flex";
        }
    </script>

</body>

</html>
