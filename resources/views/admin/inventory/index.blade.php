@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-warehouse mr-2"></i>Historial de Movimientos de Inventario
                </h1>
                <p class="text-gray-600 mt-2">Registro completo de entradas, salidas y ajustes</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.inventory.alerts') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Ver Alertas
                </a>
                <a href="{{ route('admin.inventory.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Registrar Movimiento
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('admin.inventory.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                    <select name="product_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Todos los productos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Todos los tipos</option>
                        <option value="entrada" {{ request('type') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('type') == 'salida' ? 'selected' : '' }}>Salida</option>
                        <option value="ajuste" {{ request('type') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end mt-4 space-x-2">
                <a href="{{ route('admin.inventory.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-undo mr-2"></i>Limpiar Filtros
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
            </div>
        </form>

        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Tabla de movimientos -->
        @if($movements->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Producto</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Tipo</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Cantidad</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Stock Anterior</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Stock Nuevo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Motivo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($movements as $movement)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $movement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $movement->product->name }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $movement->typeColor }}-100 text-{{ $movement->typeColor }}-800">
                                        <i class="fas fa-{{ $movement->typeIcon }} mr-1"></i>
                                        {{ ucfirst($movement->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-gray-900">
                                    {{ $movement->quantity }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-600">
                                    {{ $movement->stock_before }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-semibold text-gray-900">
                                    {{ $movement->stock_after }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $movement->reason ?? '-' }}
                                    @if($movement->reference)
                                        <span class="text-xs text-gray-500">(Ref: {{ $movement->reference }})</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $movement->user->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $movements->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No se encontraron movimientos de inventario</p>
                <a href="{{ route('admin.inventory.create') }}" 
                   class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    Registrar Primer Movimiento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
