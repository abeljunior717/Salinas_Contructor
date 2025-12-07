@extends('layouts.app')

@section('title', 'Gestionar Cotizaciones - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Gestionar Cotizaciones" subtitle="Revisa y gestiona solicitudes de cotización de clientes.">
        <x-slot name="actions">
            <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 font-bold bg-gray-700 text-white hover:bg-gray-800 transition rounded-lg"><i class="fas fa-arrow-left mr-2"></i> Volver al Panel</a>
        </x-slot>
    </x-hero>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Folio</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Cliente</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Monto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha Solicitud</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acción</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($quotations as $quotation)
                            @php
                                $isOverdue = $quotation->status === 'aceptada' && 
                                             $quotation->payment_deadline && 
                                             now()->isAfter($quotation->payment_deadline);
                                $monthsOverdue = $isOverdue ? now()->diffInMonths($quotation->payment_deadline) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 {{ $isOverdue ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 font-mono text-sm text-blue-600">
                                    {{ $quotation->reference_number }}
                                    @if($isOverdue)
                                        <span class="block text-xs text-red-600 font-bold mt-1">
                                            <i class="fas fa-exclamation-circle"></i> VENCIDA
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold">{{ $quotation->user->name }}</td>
                                <td class="px-6 py-4 font-semibold">
                                    ${{ number_format($quotation->total_amount, 2) }}
                                    @if($isOverdue && $monthsOverdue > 0)
                                        <span class="block text-xs text-red-600 font-bold mt-1">
                                            +${{ number_format($monthsOverdue * 240, 2) }} recargo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($quotation->status === 'pendiente') bg-yellow-100 text-yellow-700
                                        @elseif($quotation->status === 'aceptada') bg-green-100 text-green-700
                                        @elseif($quotation->status === 'rechazada') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($quotation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $quotation->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($quotation->approved_at)
                                        <span class="text-green-600 font-semibold">
                                            <i class="fas fa-check-circle"></i> Aceptada:<br>
                                            {{ $quotation->approved_at->format('d/m/Y H:i') }}
                                        </span>
                                        @if($isOverdue)
                                            <span class="block text-red-600 font-bold mt-1 text-xs">
                                                <i class="fas fa-clock"></i> Vencida hace {{ $monthsOverdue }} {{ $monthsOverdue == 1 ? 'mes' : 'meses' }}
                                            </span>
                                        @endif
                                    @elseif($quotation->rejected_at)
                                        <span class="text-red-600 font-semibold">
                                            <i class="fas fa-times-circle"></i> Rechazada:<br>
                                            {{ $quotation->rejected_at->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.quotations.show', $quotation) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No hay cotizaciones
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $quotations->links() }}</div>
    </div>
</div>
@endsection
