@extends('layouts.app')

@section('title', 'Gestionar Usuarios - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Gestionar Usuarios" subtitle="Ver lista de clientes y usuarios registrados.">
        <x-slot name="actions">
            <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Rol</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha de Registro</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline-block"
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</div>
@endsection
