@extends('layouts.app')

@section('title', 'Ver Cotización - Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-6">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold">Cotización #{{ $quotation->id }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detalles Principales -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <h2 class="text-2xl font-bold mb-6">Información del Cliente</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm">Folio</p>
                            <p class="text-xl font-mono text-blue-600">{{ $quotation->reference_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Nombre</p>
                            <p class="text-xl font-semibold">{{ $quotation->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="text-xl font-semibold">{{ $quotation->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Estado</p>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($quotation->status === 'pendiente') bg-yellow-100 text-yellow-700
                                @elseif($quotation->status === 'aceptada') bg-green-100 text-green-700
                                @elseif($quotation->status === 'rechazada') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Fecha de Solicitud</p>
                            <p class="text-xl font-semibold">{{ $quotation->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($quotation->approved_at)
                            <div>
                                <p class="text-gray-600 text-sm">Fecha de Aprobación</p>
                                <p class="text-xl font-semibold text-green-600">
                                    <i class="fas fa-check-circle"></i> {{ $quotation->approved_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if($quotation->rejected_at)
                            <div>
                                <p class="text-gray-600 text-sm">Fecha de Rechazo</p>
                                <p class="text-xl font-semibold text-red-600">
                                    <i class="fas fa-times-circle"></i> {{ $quotation->rejected_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if($quotation->payment_deadline)
                            @php
                                $isOverdue = now()->isAfter($quotation->payment_deadline);
                                $daysRemaining = (int)now()->diffInDays($quotation->payment_deadline, false);
                            @endphp
                            <div class="col-span-2">
                                <p class="text-gray-600 text-sm">Plazo de Pago y Recolección</p>
                                <p class="text-xl font-semibold {{ $isOverdue ? 'text-red-600' : 'text-blue-600' }}">
                                    <i class="fas fa-calendar-alt"></i> {{ $quotation->payment_deadline->format('d/m/Y') }}
                                    @if($isOverdue)
                                        <span class="text-red-600 font-bold ml-2">
                                            <i class="fas fa-exclamation-circle"></i> VENCIDA
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-600 ml-2">
                                            ({{ $daysRemaining }} días restantes)
                                        </span>
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($quotation->status === 'aceptada' && $quotation->payment_deadline && now()->isAfter($quotation->payment_deadline))
                        @php
                            $monthsOverdue = now()->diffInMonths($quotation->payment_deadline);
                            $additionalCharge = $monthsOverdue * 240;
                        @endphp
                        <div class="mt-6 bg-red-50 border-l-4 border-red-600 p-4 rounded">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-red-600 text-2xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="font-bold text-red-900 mb-2">
                                        <i class="fas fa-clock mr-1"></i> Cotización Vencida
                                    </p>
                                    <p class="text-red-800 text-sm mb-2">
                                        El plazo de pago venció hace <strong>{{ $monthsOverdue }} {{ $monthsOverdue == 1 ? 'mes' : 'meses' }}</strong>
                                    </p>
                                    <div class="bg-white rounded p-3 mt-2">
                                        <p class="text-sm text-gray-700">Monto original: <strong>${{ number_format($quotation->total_amount, 2) }}</strong></p>
                                        <p class="text-sm text-red-700">Cargo por retraso: <strong>+${{ number_format($additionalCharge, 2) }}</strong></p>
                                        <p class="text-base text-red-900 font-bold mt-1">Total actual: <strong>${{ number_format($quotation->total_amount + $additionalCharge, 2) }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Items de la Cotización -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold mb-6">Productos</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Producto</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold">Cantidad</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold">Precio Unitario</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($quotation->items as $item)
                                    <tr>
                                        <td class="px-4 py-4">{{ $item->product->name }}</td>
                                        <td class="px-4 py-4 text-center">{{ $item->quantity }} {{ $item->product->unit }}</td>
                                        <td class="px-4 py-4 text-right">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 font-semibold text-right">${{ number_format($item->line_total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen de Cotización -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-8 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6">Resumen</h2>

                    <div class="space-y-4 mb-6 border-b pb-6">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">${{ number_format($quotation->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>IVA (19%):</span>
                            <span class="font-semibold">${{ number_format($quotation->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900">
                            <span>Total:</span>
                            <span>${{ number_format($quotation->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Cambiar Estado -->
                    @if($quotation->status === 'pendiente')
                        <div class="mb-6 space-y-3">
                            <form action="{{ route('admin.quotations.approve', $quotation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition">
                                    <i class="fas fa-check mr-2"></i> Aprobar Cotización
                                </button>
                            </form>

                            <form action="{{ route('admin.quotations.reject', $quotation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition">
                                    <i class="fas fa-times mr-2"></i> Rechazar Cotización
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mb-6 p-4 rounded-lg text-center
                            @if($quotation->status === 'aceptada') bg-green-50 text-green-800 border border-green-200
                            @else bg-red-50 text-red-800 border border-red-200
                            @endif">
                            <i class="fas fa-info-circle mr-2"></i>
                            Cotización {{ $quotation->status }}
                        </div>
                    @endif

                    <a href="{{ route('admin.quotations') }}" class="block text-center bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
