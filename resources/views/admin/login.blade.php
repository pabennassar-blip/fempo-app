<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FEMPO</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            color: #667eea;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        button:hover {
            opacity: 0.9;
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        .info {
            background: #eef;
            color: #336;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9em;
            border-left: 4px solid #336;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔐 Admin</h1>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf

            <div class="form-group">
                <label for="username">Usuari:</label>
                <input type="text" id="username" name="username" required autofocus autocomplete="username">
                @error('username') <span style="color: #c33; font-size: 0.85em;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Contrasenya:</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                @error('password') <span style="color: #c33; font-size: 0.85em;">{{ $message }}</span> @enderror
            </div>

            <button type="submit">Entrar</button>
        </form>

        <p style="text-align: center; margin-top: 30px; color: #999; font-size: 0.85em;">versio2.0</p>
    </div>
</body>
</html>
