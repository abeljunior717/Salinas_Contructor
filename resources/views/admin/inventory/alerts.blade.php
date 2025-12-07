@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>Alertas de Stock Bajo
                </h1>
                <p class="text-gray-600 mt-2">Productos que requieren reabastecimiento</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.inventory.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-history mr-2"></i>Ver Historial
                </a>
                <a href="{{ route('admin.inventory.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Registrar Entrada
                </a>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- Resumen -->
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-3"></i>
                    <div>
                        <h3 class="font-bold text-red-800">¡Atención Requerida!</h3>
                        <p class="text-red-700">
                            Hay <strong>{{ $products->count() }}</strong> producto(s) con stock por debajo del mínimo establecido
                        </p>
                    </div>
                </div>
            </div>

            <!-- Lista de productos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="border border-red-200 rounded-lg p-4 bg-red-50 hover:shadow-lg transition duration-300">
                        <!-- Encabezado del producto -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-tag mr-1"></i>{{ $product->category->name ?? 'Sin categoría' }}
                                </p>
                            </div>
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                ¡BAJO!
                            </span>
                        </div>

                        <!-- Información de stock -->
                        <div class="bg-white rounded-lg p-3 mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Stock Actual:</span>
                                <span class="text-2xl font-bold text-red-600">{{ $product->stock_quantity }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Stock Mínimo:</span>
                                <span class="text-lg font-semibold text-gray-700">{{ $product->stock_min }}</span>
                            </div>

                            <!-- Barra de progreso -->
                            <div class="mt-3">
                                @php
                                    $percentage = ($product->stock_quantity / $product->stock_min) * 100;
                                    $percentage = min($percentage, 100);
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-center">
                                    {{ number_format($percentage, 1) }}% del stock mínimo
                                </p>
                            </div>
                        </div>

                        <!-- Diferencia -->
                        <div class="bg-orange-100 rounded-lg p-2 mb-3 text-center">
                            <p class="text-sm font-medium text-orange-800">
                                Faltan <span class="font-bold text-lg">{{ $product->stock_min - $product->stock_quantity }}</span> unidades
                            </p>
                        </div>

                        <!-- Acciones -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.inventory.create') }}?product_id={{ $product->id }}" 
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-3 py-2 rounded-lg transition duration-300 text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>Registrar Entrada
                            </a>
                            <a href="{{ route('products.show', $product) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg transition duration-300 text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>

                        <!-- Última actualización -->
                        @if($product->inventoryMovements->count() > 0)
                            @php
                                $lastMovement = $product->inventoryMovements->first();
                            @endphp
                            <div class="mt-3 pt-3 border-t border-red-200 text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                Último movimiento: {{ $lastMovement->created_at->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Información adicional -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <h3 class="font-bold text-blue-800 mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>Recomendaciones:
                </h3>
                <ul class="text-sm text-blue-700 space-y-1 ml-4 list-disc">
                    <li>Contacte a proveedores para reabastecer productos con stock crítico</li>
                    <li>Considere ajustar el stock mínimo si estos productos tienen baja rotación</li>
                    <li>Registre las entradas tan pronto llegue la mercancía</li>
                    <li>Puede registrar una entrada múltiple para agilizar el proceso</li>
                </ul>
            </div>

        @else
            <!-- Sin alertas -->
            <div class="text-center py-16">
                <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">¡Excelente!</h2>
                <p class="text-gray-600 text-lg mb-6">
                    No hay productos con stock bajo. Todos los productos tienen stock suficiente.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('admin.inventory.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300">
                        <i class="fas fa-history mr-2"></i>Ver Historial de Movimientos
                    </a>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition duration-300">
                        <i class="fas fa-home mr-2"></i>Volver al Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
