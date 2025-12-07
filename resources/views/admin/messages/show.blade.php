@extends('layouts.app')

@section('title', 'Ver Mensaje - Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Detalle del Mensaje</h1>
            <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        @if($message->is_read)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-envelope-open mr-1"></i> Leído
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-envelope mr-1"></i> Nuevo
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $message->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $message->name }}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <a href="mailto:{{ $message->email }}" class="text-lg text-blue-600 hover:underline">
                        {{ $message->email }}
                    </a>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Mensaje</label>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex gap-4">
                <a href="mailto:{{ $message->email }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-reply mr-2"></i> Responder por Email
                </a>
                
                @if(!$message->is_read)
                    <form action="{{ route('admin.messages.mark-read', $message) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                            <i class="fas fa-check mr-2"></i> Marcar como Leído
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.messages.mark-unread', $message) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition">
                            <i class="fas fa-envelope mr-2"></i> Marcar como No Leído
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Eliminar este mensaje?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
