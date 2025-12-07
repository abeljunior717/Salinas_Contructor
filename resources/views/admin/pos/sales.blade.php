@extends('layouts.app')

@section('title', 'Historial de Ventas')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold"><i class="fas fa-history mr-2"></i>Historial de Ventas</h1>
                    <p class="text-blue-100 mt-1">Registro de todas las transacciones</p>
                </div>
                <a href="{{ route('admin.pos.index') }}" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-bold hover:bg-blue-50 transition">
                    <i class="fas fa-cash-register mr-2"></i>Nueva Venta
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Ventas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_sales'] }}</p>
                    </div>
                    <i class="fas fa-shopping-cart text-4xl text-blue-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Ingresos Totales</p>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($stats['total_revenue'], 0) }}</p>
                    </div>
                    <i class="fas fa-dollar-sign text-4xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Ventas Hoy</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['today_sales'] }}</p>
                    </div>
                    <i class="fas fa-calendar-day text-4xl text-orange-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Ingresos Hoy</p>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($stats['today_revenue'], 0) }}</p>
                    </div>
                    <i class="fas fa-cash-register text-4xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Desde:</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Hasta:</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Método de Pago:</label>
                    <select name="payment_method" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Todos</option>
                        <option value="efectivo" {{ request('payment_method') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="tarjeta" {{ request('payment_method') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="transferencia" {{ request('payment_method') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex-1">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <a href="{{ route('admin.pos.sales') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Ventas -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Folio</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Cliente</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Items</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pago</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Total</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-sm text-blue-600">{{ $sale->sale_number }}</td>
                            <td class="px-6 py-4 text-sm">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ $sale->customer_name ?? 'Público General' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-semibold">
                                    {{ $sale->items->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm capitalize">
                                @if($sale->payment_method == 'efectivo')
                                    💵 Efectivo
                                @elseif($sale->payment_method == 'tarjeta')
                                    💳 Tarjeta
                                @else
                                    🏦 Transferencia
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">
                                ${{ number_format($sale->total_amount, 0) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.pos.show', $sale->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-semibold">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No hay ventas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection
