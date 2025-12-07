<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Salinas Constructor')</title>
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --secondary: #64748b;
            --accent: #f59e0b;
            --background: #f8fafc;
            --surface: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Navbar Minimalista */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .logo:hover {
            color: var(--primary);
        }

        .logo i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: color 0.2s ease;
            position: relative;
        }

        nav a:hover {
            color: var(--text-primary);
        }

        nav a.active {
            color: var(--text-primary);
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* Botones Modernos */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 24px;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 1.5px solid var(--border);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-yellow {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .btn-yellow:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        /* Hero Minimalista */
        .hero {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 120px 20px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 50%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -0.03em;
        }

        .hero p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
        }

        /* Cards Minimalistas */
        .card {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .product-card {
            background: var(--surface);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        .product-info {
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .product-price {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .product-unit {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 16px;
            font-weight: 500;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 16px;
            width: fit-content;
            letter-spacing: 0.01em;
        }

        .badge-disponible {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-agotado {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Filtros Modernos */
        .filter-btn {
            padding: 10px 20px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            border-radius: 24px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #eff6ff;
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Footer Moderno */
        footer {
            background: #0f172a;
            color: #cbd5e1;
        }

        footer h3 {
            color: white;
            font-weight: 700;
        }

        footer a {
            transition: all 0.2s ease;
        }

        footer a:hover {
            color: var(--primary);
        }

        /* Animaciones Suaves */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        /* Inputs Modernos */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background: var(--surface);
            color: var(--text-primary);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Scrollbar Moderna */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar Minimalista -->
    <nav class="navbar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="logo">
                <i class="fas fa-building"></i>
                <span>Salinas Constructor</span>
            </a>

            <div class="hidden md:flex gap-8 items-center">
                <a href="/" class="@if(Route::current()->getName() === null) active @endif">Inicio</a>
                <a href="{{ route('products.index') }}" class="@if(strpos(Route::current()->getName(), 'products') !== false) active @endif">Productos</a>
                <a href="{{ route('calculator.index') }}" class="@if(strpos(Route::current()->getName(), 'calculator') !== false) active @endif">Calculadora</a>
                <a href="{{ route('news.index') }}" class="@if(strpos(Route::current()->getName(), 'news') !== false) active @endif">Noticias</a>
                <a href="{{ route('contact.index') }}" class="@if(strpos(Route::current()->getName(), 'contact') !== false) active @endif">Contacto</a>

                @auth
                    <div class="flex gap-4 items-center ml-4 pl-4 border-l border-gray-200">
                        <span class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">
                                <i class="fas fa-tools"></i>
                            </a>
                        @else
                            <a href="{{ route('quotations.index') }}" class="btn btn-secondary py-2 px-4 text-sm">
                                <i class="fas fa-file-invoice"></i> Cotizaciones
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Minimalista -->
    <footer class="bg-gray-900 text-white py-16 mt-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="logo mb-4">
                        <i class="fas fa-building"></i>
                        <span class="text-white">Salinas Constructor</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Materiales de construcción de alta calidad para tus proyectos.</p>
                </div>
                <div>
                    <h3 class="font-bold mb-4 text-white">Productos</h3>
                    <ul class="text-gray-400 text-sm space-y-3">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Catálogo</a></li>
                        <li><a href="#" class="hover:text-white transition">Categorías</a></li>
                        <li><a href="#" class="hover:text-white transition">Promociones</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4 text-white">Información</h3>
                    <ul class="text-gray-400 text-sm space-y-3">
                        <li><a href="{{ route('contact.index') }}" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white transition">Noticias</a></li>
                        <li><a href="#" class="hover:text-white transition">Términos y Condiciones</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4 text-white">Síguenos</h3>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-blue-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-blue-400 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-pink-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <p class="text-center text-gray-400 text-sm">© 2025 Salinas Constructor. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Script para filtros activos
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const currentActive = document.querySelector('.filter-btn.active');
                if (currentActive) currentActive.classList.remove('active');
                this.classList.add('active');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
