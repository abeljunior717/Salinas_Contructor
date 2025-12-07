<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Salinas Constructor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e88e5;
            --light-blue: #e3f2fd;
        }
        
        body {
            background-color: #e3f2fd; /* bg-blue-50 */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(16,24,40,0.06);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }

        .login-header {
            padding: 22px 20px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0369a1; /* sky-700 */
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 0.95rem;
            color: #475569;
            margin: 0;
        }

        .login-form {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #075985; /* sky-700 */
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 8px 4px;
            border: none;
            border-bottom: 1px solid #e6eef6;
            background: transparent;
            font-size: 0.95rem;
            transition: border-color 0.15s;
        }

        .form-group input:focus {
            outline: none;
            border-bottom-color: #38bdf8; /* sky-400 */
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #38bdf8; /* sky-400 */
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.15s, box-shadow 0.15s;
            margin-top: 8px;
        }

        .btn-login:hover {
            background-color: #0ea5e9; /* sky-500 */
            box-shadow: 0 6px 18px rgba(3,105,161,0.08);
        }

        .link-section {
            text-align: center;
            margin-top: 14px;
            padding-top: 14px;
        }

        .link-section p { color: #475569; font-size: 0.9rem; margin-bottom: 6px; }
        .link-section a { color: #0369a1; font-weight: 600; }

        .error-message { background-color: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <h1>Iniciar Sesión</h1>
            <p>Accede a tu cuenta</p>
        </div>

        <!-- Formulario -->
        <div class="login-form">
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="tu@correo.com" 
                           value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small style="color: #b91c1c;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <small style="color: #b91c1c;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember -->
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; color: #475569;">
                        <input type="checkbox" name="remember" style="width: auto;">
                        <span>Recuérdame</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Links -->
            <div class="link-section">
                <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
                <p><a href="/">← Volver al inicio</a></p>
            </div>
        </div>
    </div>
</body>
</html>
