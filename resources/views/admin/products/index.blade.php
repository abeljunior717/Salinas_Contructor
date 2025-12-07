@extends('layouts.app')

@section('title', 'Gestionar Productos - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Gestionar Productos" subtitle="Crea, edita o elimina productos del catálogo.">
        <x-slot name="actions">
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
                <a href="{{ route('admin.products.create') }}" class="btn-yellow inline-block px-6 py-3 font-bold"><i class="fas fa-plus mr-2"></i> Nuevo Producto</a>
            </div>
        </x-slot>
    </x-hero>

    <div class="max-w-7xl mx-auto px-4 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Categoría</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Precio</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Unidad</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-semibold">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $product->stock_quantity > 0 ? 'bg-green-700 text-white' : 'bg-red-600 text-white' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $product->unit }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 font-semibold mr-3">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product) }}" method="POST" class="inline-block"
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No hay productos registrados. <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:underline">Crear uno ahora</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
