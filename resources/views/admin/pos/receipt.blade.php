@extends('layouts.app')

@section('title', 'Recibo de Venta')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8" id="receipt">
            <!-- Encabezado -->
            <div class="text-center border-b pb-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">SALINAS CONSTRUCTOR</h1>
                <p class="text-gray-600">Materiales de Construcción</p>
                <p class="text-sm text-gray-500 mt-2">Recibo de Venta</p>
            </div>

            <!-- Información de la venta -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Folio de Venta:</p>
                    <p class="font-bold text-lg text-blue-600">{{ $sale->sale_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Fecha y Hora:</p>
                    <p class="font-semibold">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Atendido por:</p>
                    <p class="font-semibold">{{ $sale->user->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Método de Pago:</p>
                    <p class="font-semibold capitalize">{{ $sale->payment_method }}</p>
                </div>
            </div>

            @if($sale->customer_name)
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600">Cliente:</p>
                    <p class="font-semibold">{{ $sale->customer_name }}</p>
                    @if($sale->customer_phone)
                        <p class="text-sm text-gray-600">Tel: {{ $sale->customer_phone }}</p>
                    @endif
                </div>
            @endif

            <!-- Productos -->
            <div class="mb-6">
                <table class="w-full">
                    <thead class="border-b-2 border-gray-300">
                        <tr class="text-left">
                            <th class="py-2">Producto</th>
                            <th class="py-2 text-center">Cant.</th>
                            <th class="py-2 text-right">Precio Unit.</th>
                            <th class="py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="py-3">{{ $item->product->name }}</td>
                                <td class="py-3 text-center">{{ $item->quantity }}</td>
                                <td class="py-3 text-right">${{ number_format($item->unit_price, 0) }}</td>
                                <td class="py-3 text-right font-semibold">${{ number_format($item->line_total, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totales -->
            <div class="border-t-2 border-gray-300 pt-4">
                <div class="flex justify-end mb-2">
                    <div class="w-64">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Subtotal:</span>
                            <span class="font-semibold">${{ number_format($sale->subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">IVA (19%):</span>
                            <span class="font-semibold">${{ number_format($sale->tax_amount, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-green-700 pt-2 border-t-2">
                            <span>TOTAL:</span>
                            <span>${{ number_format($sale->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie de página -->
            <div class="text-center mt-8 pt-6 border-t text-gray-500 text-sm">
                <p>¡Gracias por su compra!</p>
                <p class="mt-2">Este documento es un comprobante de venta</p>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="mt-6 flex gap-4 justify-center">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                <i class="fas fa-print mr-2"></i>Imprimir Recibo
            </button>
            <a href="{{ route('admin.pos.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                <i class="fas fa-plus-circle mr-2"></i>Nueva Venta
            </a>
            <a href="{{ route('admin.pos.sales') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
                <i class="fas fa-list mr-2"></i>Ver Historial
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #receipt, #receipt * {
        visibility: visible;
    }
    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection
