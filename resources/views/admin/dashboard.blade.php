@extends('layouts.app')

@section('title', 'Admin Dashboard - Salinas Constructor')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Panel de Administración" subtitle="Gestiona productos, categorías, noticias y cotizaciones desde aquí.">
        <x-slot name="actions">
            <a href="{{ route('admin.products') }}" class="btn-yellow inline-block px-6 py-3 font-bold">Ver Productos</a>
            <a href="{{ route('admin.news') }}" class="btn-primary inline-block px-6 py-3 font-bold">Ver Noticias</a>
        </x-slot>
    </x-hero>

    <!-- Stats Grid -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Alerta de Cotizaciones Vencidas -->
        @php
            $overdueQuotations = \App\Models\Quotation::where('status', 'aceptada')
                ->whereNotNull('payment_deadline')
                ->where('payment_deadline', '<', now())
                ->count();
        @endphp

        @if($overdueQuotations > 0)
            <div class="mb-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-times text-4xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold">¡Atención! Cotizaciones con Plazo Vencido</h3>
                            <p class="text-white/90 mt-1">
                                Hay <strong>{{ $overdueQuotations }}</strong> cotización(es) que han superado la fecha límite de pago
                            </p>
                            <p class="text-white/80 text-sm mt-1">
                                Se están aplicando cargos adicionales de $240 por mes de retraso
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('admin.quotations') }}" 
                       class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-bold transition duration-300 shadow-md">
                        <i class="fas fa-eye mr-2"></i>Ver Cotizaciones
                    </a>
                </div>
            </div>
        @endif

        <!-- Alerta de Stock Bajo -->
        @php
            $lowStockProducts = \App\Models\Product::whereColumn('stock_quantity', '<', 'stock_min')
                ->where('is_active', true)
                ->count();
        @endphp

        @if($lowStockProducts > 0)
            <div class="mb-6 bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-4xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold">¡Atención! Productos con Stock Bajo</h3>
                            <p class="text-white/90 mt-1">
                                Hay <strong>{{ $lowStockProducts }}</strong> producto(s) que requieren reabastecimiento inmediato
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('admin.inventory.alerts') }}" 
                       class="bg-white text-red-600 hover:bg-red-50 px-6 py-3 rounded-lg font-bold transition duration-300 shadow-md">
                        <i class="fas fa-eye mr-2"></i>Ver Alertas
                    </a>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <x-card class="p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Productos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="text-4xl text-blue-700">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-700 text-sm mt-4 inline-block">Ver productos →</a>
            </x-card>

            <x-card class="p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Categorías</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                    </div>
                    <div class="text-4xl text-green-700">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
                <a href="{{ route('admin.categories') }}" class="text-green-700 hover:text-green-800 text-sm mt-4 inline-block">Ver categorías →</a>
            </x-card>

            <x-card class="p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Noticias</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_news'] }}</p>
                    </div>
                    <div class="text-4xl text-orange-600">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
                <a href="{{ route('admin.news') }}" class="text-orange-600 hover:text-orange-700 text-sm mt-4 inline-block">Ver noticias →</a>
            </x-card>

            <x-card class="p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Cotizaciones Pendientes</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_quotations'] }}</p>
                    </div>
                    <div class="text-4xl text-yellow-600">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <a href="{{ route('admin.quotations') }}" class="text-yellow-600 hover:text-yellow-700 text-sm mt-4 inline-block">Ver cotizaciones →</a>
            </x-card>

            <x-card class="p-6 text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Mensajes Sin Leer</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['unread_messages'] }}</p>
                    </div>
                    <div class="text-4xl text-purple-600">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-purple-600 hover:text-purple-700 text-sm mt-4 inline-block">Ver mensajes →</a>
            </x-card>
        </div>

        <!-- Gestión Rápida -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <x-card class="text-center p-8">
                <div class="text-5xl text-blue-700 mb-4"><i class="fas fa-cube"></i></div>
                <h3 class="text-xl font-bold mb-2">Gestionar Productos</h3>
                <p class="text-gray-600 text-sm mb-6">Agregar, editar o eliminar productos del catálogo.</p>
                <a href="{{ route('admin.products') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ir a Productos</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-green-700 mb-4"><i class="fas fa-sitemap"></i></div>
                <h3 class="text-xl font-bold mb-2">Gestionar Categorías</h3>
                <p class="text-gray-600 text-sm mb-6">Crear y organizar categorías de productos.</p>
                <a href="{{ route('admin.categories') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ir a Categorías</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-orange-600 mb-4"><i class="fas fa-blog"></i></div>
                <h3 class="text-xl font-bold mb-2">Gestionar Noticias</h3>
                <p class="text-gray-600 text-sm mb-6">Publicar y editar artículos del blog.</p>
                <a href="{{ route('admin.news') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ir a Noticias</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-red-600 mb-4"><i class="fas fa-file-invoice-dollar"></i></div>
                <h3 class="text-xl font-bold mb-2">Ver Cotizaciones</h3>
                <p class="text-gray-600 text-sm mb-6">Revisar y gestionar solicitudes de cotización de clientes.</p>
                <a href="{{ route('admin.quotations') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ver Cotizaciones</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-purple-600 mb-4"><i class="fas fa-envelope"></i></div>
                <h3 class="text-xl font-bold mb-2">Ver Mensajes</h3>
                <p class="text-gray-600 text-sm mb-6">Revisar mensajes de contacto de clientes.</p>
                <a href="{{ route('admin.messages.index') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ver Mensajes</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-green-600 mb-4"><i class="fas fa-cash-register"></i></div>
                <h3 class="text-xl font-bold mb-2">Punto de Venta</h3>
                <p class="text-gray-600 text-sm mb-6">Registrar ventas y gestionar transacciones.</p>
                <a href="{{ route('admin.pos.index') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Abrir POS</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-indigo-600 mb-4"><i class="fas fa-exchange-alt"></i></div>
                <h3 class="text-xl font-bold mb-2">Entradas y Salidas</h3>
                <p class="text-gray-600 text-sm mb-6">Control de movimientos de inventario.</p>
                <a href="{{ route('admin.transactions.index') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Gestionar</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-gray-700 mb-4"><i class="fas fa-users"></i></div>
                <h3 class="text-xl font-bold mb-2">Gestionar Usuarios</h3>
                <p class="text-gray-600 text-sm mb-6">Ver lista de clientes y usuarios registrados.</p>
                <a href="{{ route('admin.users') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ver Usuarios</a>
            </x-card>

            <x-card class="text-center p-8">
                <div class="text-5xl text-indigo-600 mb-4"><i class="fas fa-warehouse"></i></div>
                <h3 class="text-xl font-bold mb-2">Inventario</h3>
                <p class="text-gray-600 text-sm mb-6">Ver el estado del inventario y alertas.</p>
                <a href="{{ route('admin.inventory.index') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ver Inventario</a>
            </x-card>
        </div>

        <!-- Cotizaciones Recientes -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold">Cotizaciones Recientes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Cliente</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Monto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_quotations as $quotation)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">{{ $quotation->user->name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold">${{ number_format($quotation->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($quotation->status === 'pendiente') bg-yellow-100 text-yellow-700
                                        @elseif($quotation->status === 'aceptada') bg-green-100 text-green-700
                                        @elseif($quotation->status === 'rechazada') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($quotation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $quotation->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.quotations.show', $quotation) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No hay cotizaciones recientes
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
