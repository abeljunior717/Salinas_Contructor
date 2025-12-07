<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Salinas Constructor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm sm:max-w-md mx-4 bg-white bg-opacity-90 rounded-md p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-center mb-6 text-sky-700">Crear Cuenta</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-sm text-sky-600 mb-1">Nombre Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm text-sky-600 mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-sm text-sky-600 mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-sky-600 mb-1">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="mt-1 w-full px-0 py-2 border-b border-gray-200 bg-transparent focus:outline-none focus:border-sky-500">
                </div>

                <!-- Botón de Registro -->
                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 rounded-md transition">
                    Crear Cuenta
                </button>
            </form>

            <p class="text-center mt-4 text-sky-600">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-sky-700 font-semibold hover:underline">Inicia sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
