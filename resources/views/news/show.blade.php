@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <a href="{{ route('news.index') }}" class="text-blue-500 hover:text-blue-700 mb-6 inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Volver a noticias
    </a>

    <article class="bg-white rounded-lg p-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-4">{{ $news->title }}</h1>
            <div class="flex gap-4 text-gray-600">
                <span><i class="fas fa-calendar-alt mr-2"></i>{{ $news->published_at->format('d/m/Y') }}</span>
                <span><i class="fas fa-user mr-2"></i>{{ $news->author->name }}</span>
                <span><i class="fas fa-eye mr-2"></i>{{ $news->views_count }} vistas</span>
            </div>
        </div>

        @if($news->featured_image_url)
            <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-full rounded-lg mb-8">
        @endif

        <div class="prose prose-lg max-w-none mb-12">
            {!! $news->content !!}
        </div>

        @if($relatedNews->count())
            <hr class="my-12">
            <h2 class="text-2xl font-bold mb-6">Artículos relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedNews as $article)
                    <a href="{{ route('news.show', $article->slug) }}" class="group">
                        <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition">
                            <div class="h-40 bg-gray-300">
                                @if($article->featured_image_url)
                                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold group-hover:text-blue-600">{{ $article->title }}</h3>
                                <p class="text-sm text-gray-600 mt-2">{{ $article->published_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</div>
@endsection
