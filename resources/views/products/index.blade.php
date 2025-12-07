@extends('layouts.app')

@section('title', 'Catálogo de Productos - Salinas Constructor')

@section('content')
<div class="min-h-screen bg-blue-50">
    <!-- Hero Section -->
    <div class="hero">
        <div class="max-w-5xl mx-auto">
            <h1>Catálogo de Productos</h1>
            <p>Explora nuestra amplia gama de materiales de construcción para cada etapa de tu proyecto.</p>
        </div>
    </div>

    <!-- Products Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Filters -->
        <div class="mb-10">
            <div class="category-filter mb-6">
                <a href="{{ route('products.index') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">
                    Todos
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                       class="filter-btn {{ request('category') === $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                <input type="text" name="search" placeholder="Buscar productos..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ request('search') }}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-bold inline-flex items-center gap-2 transition duration-300 shadow-lg">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <!-- Quotation Section -->
        <div class="mb-10 bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-file-invoice-dollar text-blue-600 mr-2"></i>
                        Solicitar Cotización
                    </h2>
                    <p class="text-gray-600">
                        Obtén precios especiales para tus proyectos. Solicita una cotización personalizada.
                    </p>
                </div>
                <div class="ml-6">
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('quotations.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold py-4 px-8 rounded-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-plus-circle mr-2"></i> Crear Cotización
                            </a>
                        @else
                            <span class="inline-block bg-gray-200 text-gray-600 font-bold py-4 px-8 rounded-lg">
                                <i class="fas fa-user-shield mr-2"></i> Modo Administrador
                            </span>
                        @endif
                    @else
                        <div class="text-center">
                            <p class="text-gray-700 mb-3 font-semibold">Para solicitar una cotización:</p>
                            <div class="flex gap-3">
                                <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="inline-block bg-green-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-700 transition">
                                    <i class="fas fa-user-plus mr-2"></i> Registrarse
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/250x200?text=' . urlencode($product->name) }}" 
                             alt="{{ $product->name }}" class="product-image">
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            
                            <div class="mb-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->status === 'disponible' ? 'bg-blue-700 text-white' : 'bg-red-600 text-white' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    Stock: {{ $product->stock_quantity }}
                                </span>
                            </div>

                            <div class="product-price">${{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="product-unit">/ {{ $product->unit }}</div>

                            <p class="text-sm text-gray-600 mb-4 flex-grow">{{ $product->description ?? 'Producto de calidad para construcción' }}</p>

                            <a href="{{ route('products.show', $product->slug) }}" class="w-full text-center inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-info-circle mr-2"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">No hay productos disponibles</p>
            </div>
        @endif
    </div>
</div>
@endsection
