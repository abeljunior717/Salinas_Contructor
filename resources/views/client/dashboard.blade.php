<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white shadow-md p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-600">Salinas Constructor</h1>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Contenido -->
        <div class="max-w-7xl mx-auto p-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-900">Bienvenido, {{ auth()->user()->name }}</h2>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Cotizaciones</p>
                            <p class="text-2xl font-bold">{{ $stats['total_quotations'] }}</p>
                        </div>
                        <i class="fas fa-file-invoice text-3xl text-blue-500"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_quotations'] }}</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-yellow-500"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Aceptadas</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['accepted_quotations'] }}</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Rechazadas</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected_quotations'] }}</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl text-red-500"></i>
                    </div>
                </div>
            </div>

            <!-- Cotizaciones Recientes -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Mis Cotizaciones Recientes</h3>
                    <a href="{{ route('quotations.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">Ver todas →</a>
                </div>
                <div class="overflow-x-auto">
                    @if($quotations->count())
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Referencia</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotations as $quotation)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-mono text-sm">{{ $quotation->reference_number }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $quotation->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-blue-600">${{ number_format($quotation->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($quotation->status === 'pendiente') bg-yellow-100 text-yellow-700
                                                @elseif($quotation->status === 'aceptada') bg-green-100 text-green-700
                                                @elseif($quotation->status === 'rechazada') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                {{ ucfirst($quotation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('quotations.show', $quotation) }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center">
                            <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-4">No tienes cotizaciones aún</p>
                            <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 inline-block">
                                <i class="fas fa-shopping-cart mr-2"></i> Ver Productos
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tarjeta: Mis Cotizaciones -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Mis Cotizaciones</h3>
                    <p class="text-gray-600 mb-4">Consulta el estado de tus solicitudes de cotización.</p>
                    <a href="{{ route('quotations.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">
                        Ver Cotizaciones
                    </a>
                </div>

                <!-- Tarjeta: Catálogo de Productos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Catálogo de Productos</h3>
                    <p class="text-gray-600 mb-4">Explora nuestro catálogo de materiales de construcción.</p>
                    <a href="{{ route('products.index') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-block">
                        Ir al Catálogo
                    </a>
                </div>

                <!-- Tarjeta: Calculadora -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Calculadora de Materiales</h3>
                    <p class="text-gray-600 mb-4">Estima los materiales necesarios para tu proyecto.</p>
                    <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                        Usar Calculadora
                    </button>
                </div>

                <!-- Tarjeta: Mi Perfil -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Mi Perfil</h3>
                    <p class="text-gray-600 mb-2"><strong>Nombre:</strong> {{ auth()->user()->name }}</p>
                    <p class="text-gray-600 mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="text-gray-600 mb-4"><strong>Tipo:</strong> <span class="text-blue-600">Cliente</span></p>
                    <button class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Editar Perfil
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
