@extends('layouts.app')

@section('title', 'Entradas y Salidas - Admin')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-6 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">
                        <i class="fas fa-exchange-alt mr-3"></i>Entradas y Salidas
                    </h1>
                    <p class="text-blue-100 mt-1">Control de movimientos de inventario</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.transactions.history') }}" class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">
                        <i class="fas fa-history mr-2"></i>Historial
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Entradas</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_entradas']) }}</p>
                    </div>
                    <i class="fas fa-arrow-down text-4xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Salidas</p>
                        <p class="text-3xl font-bold text-red-600">{{ number_format($stats['total_salidas']) }}</p>
                    </div>
                    <i class="fas fa-arrow-up text-4xl text-red-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Ajustes</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_ajustes'] }}</p>
                    </div>
                    <i class="fas fa-sliders-h text-4xl text-yellow-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Movimientos Hoy</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['movimientos_hoy'] }}</p>
                    </div>
                    <i class="fas fa-calendar-day text-4xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Panel de ENTRADA -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-6 pb-4 border-b-2 border-green-500">
                    <i class="fas fa-arrow-circle-down text-4xl text-green-600 mr-4"></i>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">ENTRADA</h2>
                        <p class="text-gray-600 text-sm">Registrar productos que ingresan al inventario</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.transactions.entry') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-box mr-2"></i>Producto
                            </label>
                            <select name="product_id" required 
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none">
                                <option value="">Seleccione un producto...</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($products->where('category_id', $category->id) as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (Stock actual: {{ $product->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-2"></i>Cantidad
                            </label>
                            <input type="number" name="quantity" min="1" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-lg"
                                   placeholder="Ingrese la cantidad">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-comment mr-2"></i>Motivo (Opcional)
                            </label>
                            <textarea name="reason" rows="3" 
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none"
                                      placeholder="Ejemplo: Compra a proveedor, Devolución, etc."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-plus-circle mr-2"></i>REGISTRAR ENTRADA
                        </button>
                    </div>
                </form>
            </div>

            <!-- Panel de SALIDA -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-6 pb-4 border-b-2 border-red-500">
                    <i class="fas fa-arrow-circle-up text-4xl text-red-600 mr-4"></i>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">SALIDA</h2>
                        <p class="text-gray-600 text-sm">Registrar productos que salen del inventario</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.transactions.exit') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-box mr-2"></i>Producto
                            </label>
                            <select name="product_id" required 
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-red-500 focus:outline-none">
                                <option value="">Seleccione un producto...</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($products->where('category_id', $category->id) as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-2"></i>Cantidad
                            </label>
                            <input type="number" name="quantity" min="1" required 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-red-500 focus:outline-none text-lg"
                                   placeholder="Ingrese la cantidad">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-comment mr-2"></i>Motivo (Opcional)
                            </label>
                            <textarea name="reason" rows="3" 
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-red-500 focus:outline-none"
                                      placeholder="Ejemplo: Venta, Merma, Donación, etc."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-minus-circle mr-2"></i>REGISTRAR SALIDA
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Movimientos Recientes -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-clock mr-2 text-blue-600"></i>Movimientos Recientes
                </h2>
                <a href="{{ route('admin.transactions.history') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Ver todo <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tipo</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Producto</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Cantidad</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Usuario</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Motivo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentMovements as $movement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    @if($movement->type === 'entrada')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <i class="fas fa-arrow-down"></i> ENTRADA
                                        </span>
                                    @elseif($movement->type === 'salida')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            <i class="fas fa-arrow-up"></i> SALIDA
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                            <i class="fas fa-sliders-h"></i> AJUSTE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-semibold">{{ $movement->product->name }}</td>
                                <td class="px-4 py-3 text-center font-bold text-lg">{{ $movement->quantity }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $movement->user->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $movement->reason ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    No hay movimientos registrados
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
