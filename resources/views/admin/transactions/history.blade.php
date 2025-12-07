@extends('layouts.app')

@section('title', 'Historial de Movimientos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-indigo-700 to-purple-700 text-white py-6 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">
                        <i class="fas fa-history mr-3"></i>Historial de Movimientos
                    </h1>
                    <p class="text-indigo-100 mt-1">Registro completo de entradas y salidas</p>
                </div>
                <a href="{{ route('admin.transactions.index') }}" class="bg-white text-indigo-700 px-6 py-3 rounded-lg font-bold hover:bg-indigo-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Movimientos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_movimientos']) }}</p>
                    </div>
                    <i class="fas fa-list text-4xl text-blue-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Entradas del Mes</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($stats['entradas_mes']) }}</p>
                    </div>
                    <i class="fas fa-arrow-down text-4xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Salidas del Mes</p>
                        <p class="text-3xl font-bold text-red-600">{{ number_format($stats['salidas_mes']) }}</p>
                    </div>
                    <i class="fas fa-arrow-up text-4xl text-red-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Valor Inventario</p>
                        <p class="text-2xl font-bold text-purple-600">${{ number_format($stats['valor_inventario'], 0) }}</p>
                    </div>
                    <i class="fas fa-dollar-sign text-4xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold mb-4"><i class="fas fa-filter mr-2"></i>Filtrar Movimientos</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Tipo:</label>
                    <select name="type" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('type') == 'entrada' ? 'selected' : '' }}>Entradas</option>
                        <option value="salida" {{ request('type') == 'salida' ? 'selected' : '' }}>Salidas</option>
                        <option value="ajuste" {{ request('type') == 'ajuste' ? 'selected' : '' }}>Ajustes</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Producto:</label>
                    <select name="product_id" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Todos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

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

                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex-1">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    <a href="{{ route('admin.transactions.history') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Movimientos -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-100 to-gray-200 border-b-2">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Producto</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Cantidad</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Stock Antes</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Stock Después</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Usuario</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Fecha y Hora</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Motivo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if($movement->type === 'entrada')
                                        <span class="px-4 py-2 rounded-full text-xs font-bold bg-green-100 text-green-800 border-2 border-green-300">
                                            <i class="fas fa-arrow-circle-down mr-1"></i>ENTRADA
                                        </span>
                                    @elseif($movement->type === 'salida')
                                        <span class="px-4 py-2 rounded-full text-xs font-bold bg-red-100 text-red-800 border-2 border-red-300">
                                            <i class="fas fa-arrow-circle-up mr-1"></i>SALIDA
                                        </span>
                                    @else
                                        <span class="px-4 py-2 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border-2 border-yellow-300">
                                            <i class="fas fa-sliders-h mr-1"></i>AJUSTE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $movement->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->product->category->name ?? 'Sin categoría' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xl font-bold {{ $movement->type === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $movement->type === 'entrada' ? '+' : '-' }}{{ $movement->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-gray-600">
                                    {{ $movement->stock_before }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-blue-600">
                                    {{ $movement->stock_after }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-semibold text-gray-700">{{ $movement->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div>{{ $movement->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $movement->reason ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-400"></i>
                                    <p class="text-lg">No hay movimientos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
