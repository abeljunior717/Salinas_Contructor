<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Salinas Constructor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm sm:max-w-md mx-4 bg-white bg-opacity-90 rounded-md p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-center mb-6 text-sky-700">Iniciar Sesión</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                        <label for="email" class="block text-sm text-sky-600 mb-1">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                </div>

                <!-- Contraseña -->
                <div class="mb-6">
                    <label for="password" class="block text-sm text-sky-600 mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                </div>

                <!-- Recordarme -->
                <div class="mb-6 flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-sky-500 focus:ring-sky-400 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-sky-600">Recuérdame</label>
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 rounded-md transition">
                    Iniciar Sesión
                </button>
            </form>

            <p class="text-center mt-4 text-sky-600">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-sky-700 font-semibold hover:underline">Regístrate aquí</a>
            </p>
        </div>
    </div>
</body>
</html>
