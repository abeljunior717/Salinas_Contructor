@extends('layouts.app')

@section('title', 'Gestionar Noticias - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Gestionar Noticias" subtitle="Publica y edita artículos del blog.">
        <x-slot name="actions">
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
                <a href="{{ route('admin.news.create') }}" class="btn-yellow inline-block px-6 py-3 font-bold"><i class="fas fa-plus mr-2"></i> Nueva Noticia</a>
            </div>
        </x-slot>
    </x-hero>

    <div class="max-w-7xl mx-auto px-4 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">✅ {{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Autor</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($news as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">{{ $article->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->user->name ?? 'Admin' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.news.edit', $article) }}" class="text-blue-600 hover:text-blue-700 font-semibold mr-3">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.news.delete', $article) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No hay noticias. <a href="{{ route('admin.news.create') }}" class="text-blue-600 hover:underline">Crear una</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $news->links() }}</div>
    </div>
</div>
@endsection
