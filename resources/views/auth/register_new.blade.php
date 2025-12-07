<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Salinas Constructor</title>
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

        .register-container {
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(16,24,40,0.06);
            overflow: hidden;
            max-width: 460px;
            width: 100%;
        }

        .register-header {
            padding: 22px 20px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0369a1; /* sky-700 */
            margin-bottom: 6px;
        }

        .register-header p { color: #475569; margin:0; }

        .register-form { padding: 20px; }

        .form-group { margin-bottom: 12px; }

        .form-group label { display:block; font-weight:600; color:#075985; margin-bottom:6px; }

        .form-group input { width:100%; padding:8px 4px; border:none; border-bottom:1px solid #e6eef6; background:transparent; }

        .form-group input:focus { outline:none; border-bottom-color:#38bdf8; }

        .btn-register { width:100%; padding:12px; background-color:#38bdf8; color:white; border-radius:8px; font-weight:600; }

        .btn-register:hover { background-color:#0ea5e9; }

        .link-section { text-align:center; margin-top:12px; }

        .error-message { background-color:#fee2e2; color:#b91c1c; padding:10px; border-radius:8px; margin-bottom:12px; }

        .success-message { background-color:#ecfdf5; color:#047857; padding:10px; border-radius:8px; margin-bottom:12px; }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <h1>Crear cuenta</h1>
            <p>Regístrate para gestionar tus cotizaciones</p>
        </div>

        <!-- Formulario -->
        <div class="register-form">
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    Revisa los errores abajo
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre Completo -->
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" id="name" name="name" placeholder="Ej. Juan Pérez" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: #b91c1c;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="tu@correo.com" 
                           value="{{ old('email') }}" required>
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

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           placeholder="••••••••" required>
                    @error('password_confirmation')
                        <small style="color: #b91c1c;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-register">
                    Crear Cuenta
                </button>
            </form>

            <!-- Links -->
            <div class="link-section">
                <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
                <p><a href="/">← Volver al inicio</a></p>
            </div>
        </div>
    </div>
</body>
</html>
