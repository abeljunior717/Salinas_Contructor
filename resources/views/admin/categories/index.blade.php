@extends('layouts.app')

@section('title', 'Gestionar Categorías - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Gestionar Categorías" subtitle="Crea y organiza categorías de productos.">
        <x-slot name="actions">
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
                <a href="{{ route('admin.categories.create') }}" class="btn-yellow inline-block px-6 py-3 font-bold"><i class="fas fa-plus mr-2"></i> Nueva Categoría</a>
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Slug</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Productos</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $category->products_count }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-700 font-semibold mr-3">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.categories.delete', $category) }}" method="POST" class="inline-block"
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
                                    No hay categorías. <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:underline">Crear una</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $categories->links() }}</div>
    </div>
</div>
@endsection
