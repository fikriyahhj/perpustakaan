<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - fikriyah's page</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #eef5ff, #ffffff);
        }

        .login-container {
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            color: #365CF5;
            margin-bottom: 10px;
        }

        .login-container p {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            font-size: 15px;
        }

        .form-group input:focus {
            border-color: #365CF5;
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #365CF5;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #2949c7;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #365CF5;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h1>Selamat datang</h1>
        <p>Silakan login untuk masuk ke halaman admin.</p>

        <form action="/admin" method="GET">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password">
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>

        </form>

        <a href="/" class="back-home">← Kembali ke Beranda</a>

    </div>

</body>
</html>