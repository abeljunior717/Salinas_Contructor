@extends('layouts.app')

@section('title', 'Mis Cotizaciones')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Mis Cotizaciones</h1>

    @if($quotations->count())
        <div class="bg-white rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold">Nro. Cotización</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Total</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Estado</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $quotation)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-mono font-bold">{{ $quotation->reference_number }}</td>
                            <td class="px-6 py-3">{{ $quotation->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 font-bold text-blue-600">${{ number_format($quotation->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-sm font-bold
                                    @if($quotation->status === 'pendiente') bg-yellow-200 text-yellow-800
                                    @elseif($quotation->status === 'aceptada') bg-green-200 text-green-800
                                    @else bg-red-200 text-red-800
                                    @endif">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <a href="{{ route('quotations.show', $quotation) }}" class="text-blue-600 hover:underline">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $quotations->links() }}
        </div>
    @else
        <div class="bg-white p-12 rounded-lg text-center">
            <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 mb-6">No tienes cotizaciones aún</p>
            <a href="{{ route('products.index') }}" class="btn-primary">
                <i class="fas fa-shopping-cart mr-2"></i> Ver productos
            </a>
        </div>
    @endif
</div>
@endsection
