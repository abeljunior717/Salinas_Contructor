@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('admin.pos.sales') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Volver al historial
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Encabezado -->
            <div class="border-b pb-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Venta {{ $sale->sale_number }}</h1>
                        <p class="text-gray-600">{{ $sale->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                        {{ ucfirst($sale->status) }}
                    </span>
                </div>
            </div>

            <!-- Información -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Atendido por:</p>
                    <p class="font-semibold text-lg">{{ $sale->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Método de Pago:</p>
                    <p class="font-semibold text-lg capitalize">
                        @if($sale->payment_method == 'efectivo')
                            💵 Efectivo
                        @elseif($sale->payment_method == 'tarjeta')
                            💳 Tarjeta
                        @else
                            🏦 Transferencia
                        @endif
                    </p>
                </div>
                @if($sale->customer_name)
                    <div class="col-span-2 bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Cliente:</p>
                        <p class="font-semibold text-lg">{{ $sale->customer_name }}</p>
                        @if($sale->customer_phone)
                            <p class="text-gray-700">Tel: {{ $sale->customer_phone }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Productos -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4">Productos Vendidos</h2>
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Producto</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold">Cantidad</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold">Precio Unit.</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($sale->items as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3">{{ $item->product->name }}</td>
                                    <td class="px-4 py-3 text-center font-semibold">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right">${{ number_format($item->unit_price, 0) }}</td>
                                    <td class="px-4 py-3 text-right font-bold text-green-600">
                                        ${{ number_format($item->line_total, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="flex justify-end">
                <div class="w-80 bg-gray-50 rounded-lg p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">${{ number_format($sale->subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>IVA (19%):</span>
                            <span class="font-semibold">${{ number_format($sale->tax_amount, 0) }}</span>
                        </div>
                        <div class="border-t-2 border-gray-300 pt-3">
                            <div class="flex justify-between text-2xl font-bold text-green-700">
                                <span>TOTAL:</span>
                                <span>${{ number_format($sale->total_amount, 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-8 flex gap-4 justify-center border-t pt-6">
                <a href="{{ route('admin.pos.receipt', $sale->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                    <i class="fas fa-receipt mr-2"></i>Ver Recibo
                </a>
                <a href="{{ route('admin.pos.sales') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
                    <i class="fas fa-list mr-2"></i>Volver al Historial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
