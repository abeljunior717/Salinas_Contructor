@extends('layouts.app')

@section('title', 'Noticias')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4">Noticias y Artículos</h1>
        <p class="text-gray-600 text-lg">Mantente informado sobre las últimas novedades en materiales de construcción</p>
    </div>

    @if($news->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($news as $article)
                <a href="{{ route('news.show', $article->slug) }}" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                        <div class="h-48 bg-gray-300 overflow-hidden">
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
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $article->published_at->format('d/m/Y') }}
                            </p>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600">{{ $article->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $article->excerpt ?? Str::limit($article->content, 100) }}</p>
                            <span class="text-blue-600 font-bold hover:underline">Leer más →</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-newspaper text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600">No hay noticias disponibles</p>
        </div>
    @endif
</div>
@endsection
