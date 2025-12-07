@extends('layouts.app')

@section('title', 'Salinas Constructor - Inicio')

@section('content')
<div class="min-h-screen bg-blue-50">
    <!-- Hero Section -->
    <div class="hero">
        <div class="max-w-5xl mx-auto">
            <h1>Calidad y Confianza en Materiales para Construcción</h1>
            <p>Tu aliado para construir grandes proyectos. Todo lo que necesitas, en un solo lugar.</p>
            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-bold inline-flex items-center gap-2 transition duration-300 shadow-lg">
                <i class="fas fa-info-circle"></i>
                Ver Catálogo
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Amplio Catálogo</h3>
                <p class="text-gray-600">Miles de productos de construcción disponibles</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calculator text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Calculadora</h3>
                <p class="text-gray-600">Estima materiales para tus proyectos</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Soporte 24/7</h3>
                <p class="text-gray-600">Atención profesional en todo momento</p>
            </div>
        </div>
    </div>

    <!-- Latest News -->
    <!-- Productos Destacados -->
    <div class="max-w-7xl mx-auto px-4 py-20">
        <h2 class="text-3xl font-bold text-center mb-4">Productos Destacados</h2>
        <p class="text-center text-gray-600 mb-8">Los materiales más solicitados por nuestros clientes.</p>

        @php
            $featuredSlugs = ['cemento-portland-50kg', 'varilla-corrugada-1-2', 'arena-fina'];
            $featured = \App\Models\Product::whereIn('slug', $featuredSlugs)->get()->keyBy('slug');
            $items = [
                'cemento-portland-50kg' => 'Cemento Portland 50kg',
                'varilla-corrugada-1-2' => 'Varilla Corrugada 1/2"',
                'arena-fina' => 'Grava / Arena Fina',
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($items as $slug => $label)
                @php $p = $featured->has($slug) ? $featured[$slug] : null; @endphp
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <a href="{{ $p ? route('products.show', $p->slug) : route('products.index') }}" class="group block">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            @if($p && $p->image_url)
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold text-xl">{{ $label }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2">{{ $p ? $p->name : $label }}</h3>
                            @if($p && isset($p->price))
                                <p class="text-gray-700 font-semibold">${{ number_format($p->price, 0, ',', '.') }}</p>
                            @else
                                <p class="text-gray-600">Desde $0</p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-bold inline-flex items-center gap-2 transition duration-300 shadow-lg">
                <i class="fas fa-info-circle"></i>
                Ver más productos
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-20">
        <h2 class="text-3xl font-bold text-center mb-12">Últimas Noticias</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php $latestNews = \App\Models\News::published()->latest()->take(3)->get(); @endphp
            @forelse($latestNews as $article)
                <a href="{{ route('news.show', $article->slug) }}" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                        <div class="h-48 bg-gray-300">
                            @if($article->featured_image_url)
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-500 mb-2">{{ $article->published_at->format('d/m/Y') }}</p>
                            <h3 class="text-lg font-bold mb-2">{{ $article->title }}</h3>
                            <span class="text-blue-600 font-bold hover:underline">Leer más →</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-gray-600 text-center col-span-3">No hay noticias disponibles</p>
            @endforelse
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('news.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-bold inline-flex items-center gap-2 transition duration-300 shadow-lg">
                <i class="fas fa-info-circle"></i>
                Ver todas las noticias
            </a>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-sky-400 to-sky-500 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">¿Necesitas una Cotización?</h2>
            <p class="text-lg mb-8">Crea tu cuenta y solicita cotizaciones personalizadas</p>
            @auth
                <a href="{{ route('quotations.create') }}" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                    Crear Cotización
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                    Registrarse Ahora
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
