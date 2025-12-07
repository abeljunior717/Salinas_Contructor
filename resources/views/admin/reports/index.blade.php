@extends('layouts.app')

@section('title', 'Reportes - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Reportes y Estadísticas" subtitle="Visualiza datos y reportes del negocio.">
        <x-slot name="actions">
            <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
        </x-slot>
    </x-hero>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Stats Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Productos Totales</p>
                        <p class="text-3xl font-bold">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="text-4xl text-blue-700"><i class="fas fa-box"></i></div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Categorías</p>
                        <p class="text-3xl font-bold">{{ $stats['total_categories'] }}</p>
                    </div>
                    <div class="text-4xl text-green-700"><i class="fas fa-layer-group"></i></div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Clientes</p>
                        <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="text-4xl text-indigo-700"><i class="fas fa-users"></i></div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Cotizaciones Totales</p>
                        <p class="text-3xl font-bold">{{ $stats['total_quotations'] }}</p>
                    </div>
                    <div class="text-4xl text-orange-600"><i class="fas fa-file-invoice"></i></div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Cotizaciones por Estado -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Cotizaciones por Estado</h2>
                <div class="space-y-4">
                    @php
                        $pending = $quotations_by_status->where('status', 'pending')->first();
                        $approved = $quotations_by_status->where('status', 'approved')->first();
                        $rejected = $quotations_by_status->where('status', 'rejected')->first();
                        
                        $total_quotes = ($pending->count ?? 0) + ($approved->count ?? 0) + ($rejected->count ?? 0);
                    @endphp

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold text-gray-700">Pendientes</span>
                            <span class="font-bold text-yellow-600">{{ $pending->count ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $total_quotes > 0 ? (($pending->count ?? 0) / $total_quotes) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold text-gray-700">Aprobadas</span>
                            <span class="font-bold text-green-600">{{ $approved->count ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-400 h-2 rounded-full" style="width: {{ $total_quotes > 0 ? (($approved->count ?? 0) / $total_quotes) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold text-gray-700">Rechazadas</span>
                            <span class="font-bold text-red-600">{{ $rejected->count ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-400 h-2 rounded-full" style="width: {{ $total_quotes > 0 ? (($rejected->count ?? 0) / $total_quotes) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos por Categoría -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Productos por Categoría</h2>
                <div class="space-y-4">
                    @forelse($products_by_category as $item)
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold text-gray-700">{{ $item->category->name ?? 'Sin categoría' }}</span>
                                <span class="font-bold text-blue-600">{{ $item->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-400 h-2 rounded-full" style="width: {{ ($item->count / $stats['total_products']) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Resumen de Contenido -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold mb-4">Noticias Publicadas</h3>
                <p class="text-4xl font-bold text-orange-600 mb-2">{{ $stats['total_news'] }}</p>
                <p class="text-gray-600">Artículos publicados en el blog</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold mb-4">Usuarios Registrados</h3>
                <p class="text-4xl font-bold text-purple-600 mb-2">{{ $stats['total_users'] }}</p>
                <p class="text-gray-600">Clientes activos en el sistema</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold mb-4">Administradores</h3>
                <p class="text-4xl font-bold text-red-600 mb-2">{{ $stats['total_admins'] ?? 1 }}</p>
                <p class="text-gray-600">Usuarios con acceso admin</p>
            </div>
        </div>
    </div>
</div>
@endsection
