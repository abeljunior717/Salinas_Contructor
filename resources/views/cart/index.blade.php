@extends('layouts.app')

@section('title', 'Mi Carrito - Salinas Constructor')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl font-bold">Mi Carrito de Compras</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if($cart_items->isEmpty())
            <div class="bg-white rounded-lg p-12 text-center shadow-md">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-600 mb-6">Comienza a agregar productos para crear una cotización.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a Productos
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Productos en Carrito -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold">Productos en tu Carrito ({{ $cart_items->count() }})</h2>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @foreach($cart_items as $item)
                                <div class="p-6 hover:bg-gray-50 transition">
                                    <div class="flex gap-6">
                                        <!-- Imagen -->
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/100' }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-24 h-24 object-cover rounded-lg">
                                        </div>

                                        <!-- Detalles -->
                                        <div class="flex-grow">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $item->product->description }}</p>
                                            <p class="text-blue-600 font-semibold mt-2">${{ number_format($item->price, 2) }} por {{ $item->product->unit }}</p>
                                        </div>

                                        <!-- Cantidad y Total -->
                                        <div class="text-right">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-block mb-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex gap-2 items-center justify-end">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                           min="1" class="w-16 px-2 py-1 border border-gray-300 rounded"
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>
                                            <p class="text-xl font-bold text-gray-900">${{ number_format($item->quantity * $item->price, 2) }}</p>

                                            <!-- Remover -->
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="mt-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                                                    <i class="fas fa-trash mr-1"></i> Remover
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón de Volver -->
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-block text-blue-600 hover:text-blue-700 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i> Continuar comprando
                        </a>
                    </div>
                </div>

                <!-- Resumen de Carrito -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md sticky top-24 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold">Resumen de Cotización</h2>
                        </div>

                        <div class="px-6 py-4">
                            <!-- Desglose -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>IVA (19%):</span>
                                    <span>${{ number_format($total * 0.19, 2) }}</span>
                                </div>
                                <div class="border-t pt-3">
                                    <div class="flex justify-between text-xl font-bold text-gray-900">
                                        <span>Total:</span>
                                        <span>${{ number_format($total * 1.19, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón de Checkout -->
                            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition">
                                    <i class="fas fa-check mr-2"></i> Crear Cotización
                                </button>
                            </form>

                            <!-- Info -->
                            <div class="mt-6 bg-blue-50 rounded-lg p-4 text-sm text-gray-700">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                <strong>Nota:</strong> Un asesor de ventas se pondrá en contacto para confirmar precios y disponibilidad.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
