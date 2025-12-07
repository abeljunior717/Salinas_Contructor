@extends('layouts.app')

@section('title', 'Nueva Noticia - Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-6">
        <div class="max-w-2xl mx-auto px-4">
            <h1 class="text-3xl font-bold">Nueva Noticia</h1>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.news.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold mb-2">Título</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Extracto</label>
                    <textarea name="excerpt" rows="2" placeholder="Resumen corto de la noticia"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Contenido</label>
                    <textarea name="content" rows="8" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">URL de Imagen</label>
                    <input type="url" name="featured_image_url" value="{{ old('featured_image_url') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Publicar
                    </button>
                    <a href="{{ route('admin.news') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 rounded-lg transition text-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
