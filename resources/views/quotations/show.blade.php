@extends('layouts.app')

@section('title', 'Cotización ' . $quotation->reference_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-400 rounded-lg p-8 mb-8 text-center">
            <i class="fas fa-check-circle text-green-600 text-6xl mb-4"></i>
            <h2 class="text-3xl font-bold text-green-800 mb-3">¡Solicitud de Cotización Enviada!</h2>
            <p class="text-green-700 text-lg mb-6">Espere unos momentos para que su solicitud sea aceptada</p>
            <a href="{{ url('/') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                <i class="fas fa-home mr-2"></i> Regresar al Inicio
            </a>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6">
            <a href="{{ route('quotations.index') }}" class="text-blue-500 hover:text-blue-700 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver a mis cotizaciones
            </a>
        </div>

        <!-- Encabezado con Estado -->
        <div class="border-b pb-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Cotización</h1>
                    <p class="text-lg font-mono text-blue-600 mt-2">Folio: {{ $quotation->reference_number }}</p>
                    <p class="text-gray-600 mt-2">Fecha de solicitud: {{ $quotation->created_at->format('d/m/Y H:i') }}</p>
                    @if($quotation->approved_at)
                        <p class="text-green-600 font-semibold mt-1">
                            <i class="fas fa-check-circle"></i> Aceptada: {{ $quotation->approved_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                    @if($quotation->rejected_at)
                        <p class="text-red-600 font-semibold mt-1">
                            <i class="fas fa-times-circle"></i> Rechazada: {{ $quotation->rejected_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                </div>
                <span class="px-6 py-3 rounded-lg text-lg font-bold
                    @if($quotation->status === 'pendiente') bg-yellow-100 text-yellow-800 border-2 border-yellow-300
                    @elseif($quotation->status === 'aceptada') bg-green-100 text-green-800 border-2 border-green-300
                    @elseif($quotation->status === 'rechazada') bg-red-100 text-red-800 border-2 border-red-300
                    @else bg-gray-100 text-gray-800 border-2 border-gray-300
                    @endif">
                    <i class="fas 
                        @if($quotation->status === 'pendiente') fa-clock
                        @elseif($quotation->status === 'aceptada') fa-check-circle
                        @elseif($quotation->status === 'rechazada') fa-times-circle
                        @else fa-question-circle
                        @endif mr-2"></i>
                    {{ ucfirst($quotation->status) }}
                </span>
            </div>

            <!-- Mensaje según Estado -->
            @if($quotation->status === 'pendiente')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex items-start">
                        <i class="fas fa-hourglass-half text-yellow-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <p class="font-bold text-yellow-800">Su solicitud está siendo revisada</p>
                            <p class="text-yellow-700 text-sm">Nuestro equipo está revisando su cotización. Le notificaremos cuando sea procesada.</p>
                        </div>
                    </div>
                </div>
            @elseif($quotation->status === 'aceptada')
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <p class="font-bold text-green-800">¡Cotización Aceptada!</p>
                            <p class="text-green-700 text-sm">Su cotización ha sido aprobada. Nos pondremos en contacto con usted pronto.</p>
                        </div>
                    </div>
                </div>
            @elseif($quotation->status === 'rechazada')
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex items-start">
                        <i class="fas fa-times-circle text-red-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <p class="font-bold text-red-800">Cotización No Aceptada</p>
                            <p class="text-red-700 text-sm">Lamentablemente no pudimos procesar esta cotización. Puede crear una nueva solicitud o contactarnos para más información.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Productos Solicitados -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-900">Productos Solicitados</h2>
            <div class="bg-gray-50 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Producto</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Cantidad</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Precio Unitario</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($quotation->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 text-gray-900">{{ $item->product->name }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $item->quantity }} {{ $item->product->unit }}</td>
                                <td class="px-6 py-4 text-right text-gray-700">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900">${{ number_format($item->line_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Resumen de Totales -->
        <div class="flex justify-end">
            <div class="w-full md:w-96 bg-gray-50 rounded-lg p-6">
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span class="font-semibold">${{ number_format($quotation->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>IVA (19%):</span>
                        <span class="font-semibold">${{ number_format($quotation->tax_amount, 0, ',', '.') }}</span>
                    </div>
                    @if($quotation->discount_amount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Descuento:</span>
                            <span class="font-semibold">-${{ number_format($quotation->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="border-t-2 border-gray-300 pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($quotation->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($quotation->notes)
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4">
                <h3 class="font-bold text-blue-900 mb-2"><i class="fas fa-sticky-note mr-2"></i>Notas de su solicitud:</h3>
                <p class="text-blue-800">{{ $quotation->notes }}</p>
            </div>
        @endif

        <!-- Mensajes según el estado de la cotización -->
        @if($quotation->status === 'aceptada')
            <div class="mt-6 bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-400 rounded-lg p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-handshake text-green-600 text-4xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-green-900 mb-3">
                            <i class="fas fa-check-circle mr-2"></i>¡Felicidades! Su cotización ha sido aceptada
                        </h3>
                        <p class="text-green-800 text-base leading-relaxed mb-4">
                            Lo(a) esperamos en nuestro comercio. Le entregaremos los materiales una vez haya pagado en nuestro comercio.
                        </p>
                        
                        <!-- Plazo de pago -->
                        <div class="bg-white rounded-lg p-4 mb-4 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-700 font-semibold mb-1">
                                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                        Plazo para pago y recolección:
                                    </p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ $quotation->payment_deadline->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $daysRemaining = now()->diffInDays($quotation->payment_deadline, false);
                                        $daysRemaining = $daysRemaining >= 0 ? (int)$daysRemaining : 0;
                                    @endphp
                                    <p class="text-sm text-gray-600">Días restantes:</p>
                                    <p class="text-3xl font-bold {{ $daysRemaining > 7 ? 'text-green-700' : ($daysRemaining > 3 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $daysRemaining }}
                                    </p>
                                    <p class="text-sm text-gray-600">días</p>
                                </div>
                            </div>
                        </div>

                        <!-- Aviso de cargo por retraso -->
                        @php
                            $isOverdue = now()->isAfter($quotation->payment_deadline);
                            $monthsOverdue = $isOverdue ? now()->diffInMonths($quotation->payment_deadline) : 0;
                            $additionalCharge = $monthsOverdue * 240;
                        @endphp

                        @if($isOverdue)
                            <!-- Cotización vencida -->
                            <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-red-600 text-2xl mr-3 mt-1"></i>
                                    <div class="flex-1">
                                        <p class="font-bold text-red-900 mb-2 text-lg">
                                            <i class="fas fa-clock mr-1"></i> ¡Plazo Vencido!
                                        </p>
                                        <p class="text-red-800 mb-3">
                                            El plazo de pago y recolección ha expirado.
                                            Han transcurrido <strong>{{ $monthsOverdue }} {{ $monthsOverdue == 1 ? 'mes' : 'meses' }}</strong> desde la fecha límite.
                                        </p>
                                        <div class="bg-white rounded p-3 border border-red-200">
                                            <p class="text-gray-700 mb-1">Monto original:</p>
                                            <p class="text-xl font-bold text-gray-900">${{ number_format($quotation->total_amount, 2) }}</p>
                                            <p class="text-gray-700 mb-1 mt-2">Cargo por retraso ({{ $monthsOverdue }} {{ $monthsOverdue == 1 ? 'mes' : 'meses' }} × $240):</p>
                                            <p class="text-xl font-bold text-red-600">+${{ number_format($additionalCharge, 2) }}</p>
                                            <hr class="my-2 border-gray-300">
                                            <p class="text-gray-700 mb-1">Total a pagar ahora:</p>
                                            <p class="text-2xl font-bold text-red-700">${{ number_format($quotation->total_amount + $additionalCharge, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Aviso preventivo -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3 mt-1"></i>
                                    <div>
                                        <p class="font-bold text-yellow-900 mb-2">
                                            <i class="fas fa-info-circle mr-1"></i> Importante: Cargo por retraso
                                        </p>
                                        <p class="text-yellow-800 text-sm">
                                            Si no realiza el pago y recolección dentro del plazo establecido (1 mes), 
                                            se aplicará un <strong class="text-yellow-900">cargo adicional de $240.00 por cada mes</strong> 
                                            que transcurra después de la fecha límite.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <p class="text-green-700 font-semibold mt-4">
                            Saludos cordiales,<br>
                            <span class="text-green-900">Equipo Salinas Constructor</span>
                        </p>
                    </div>
                </div>
            </div>
        @elseif($quotation->status === 'rechazada')
            <div class="mt-6 bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-400 rounded-lg p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-red-900 mb-3">
                            Cotización No Aprobada
                        </h3>
                        <p class="text-red-800 text-base leading-relaxed">
                            Al parecer su cotización no es apta.
                        </p>
                        <p class="text-red-700 font-semibold mt-3">
                            Saludos,<br>
                            <span class="text-red-900">Equipo Salinas Constructor</span>
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('quotations.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i> Crear Nueva Cotización
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
