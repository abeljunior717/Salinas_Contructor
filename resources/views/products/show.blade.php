@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700 mb-6 inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Volver al catálogo
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-lg">
        <!-- Image -->
        <div>
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/500x500?text=' . urlencode($product->name) }}" 
                 alt="{{ $product->name }}" class="w-full rounded-lg">
        </div>

        <!-- Info -->
        <div>
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            
            <!-- Información de Precio y Stock en Resumen -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <div class="text-4xl font-bold text-blue-600 mb-2">${{ number_format($product->price, 0, ',', '.') }}</div>
                <p class="text-gray-600 mb-4">Por {{ $product->unit }}</p>
                <div class="flex gap-4 text-sm">
                    <span class="px-3 py-1 rounded-full {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->stock_quantity > 0 ? 'Disponible' : 'No disponible' }}
                    </span>
                    <span class="text-gray-600">Stock: <strong>{{ $product->stock_quantity }}</strong></span>
                </div>
            </div>

            <!-- Sección de Detalles en Resumen -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h3 class="font-bold mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i> Detalles del producto
                </h3>

                @php
                    $hasDetails = false;
                @endphp

                <!-- Información Técnica Específica en Grid -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                    @if(!empty($product->color))
                        @php $hasDetails = true; @endphp
                        <div><strong>Color:</strong> {{ $product->color }}</div>
                    @endif
                    @if(!empty($product->performance))
                        @php $hasDetails = true; @endphp
                        <div><strong>Rendimiento:</strong> {{ $product->performance }}</div>
                    @endif
                    @if(!empty($product->material_type))
                        @php $hasDetails = true; @endphp
                        <div><strong>Material:</strong> {{ $product->material_type }}</div>
                    @endif
                    @if(!empty($product->weight_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Peso:</strong> {{ $product->weight_spec }}</div>
                    @endif
                    @if(!empty($product->accessories))
                        @php $hasDetails = true; @endphp
                        <div><strong>Accesorios:</strong> {{ $product->accessories }}</div>
                    @endif
                    @if(!empty($product->warranty))
                        @php $hasDetails = true; @endphp
                        <div><strong>Garantía:</strong> {{ $product->warranty }}</div>
                    @endif
                    @if(!empty($product->package_content))
                        @php $hasDetails = true; @endphp
                        <div><strong>Empaque:</strong> {{ $product->package_content }}</div>
                    @endif
                    @if(!empty($product->model_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Modelo:</strong> {{ $product->model_spec }}</div>
                    @endif
                    @if(!empty($product->height_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Alto:</strong> {{ $product->height_spec }} cm</div>
                    @endif
                    @if(!empty($product->width_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Ancho:</strong> {{ $product->width_spec }} cm</div>
                    @endif
                    @if(!empty($product->length_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Largo:</strong> {{ $product->length_spec }} cm</div>
                    @endif
                    @if(!empty($product->depth_spec))
                        @php $hasDetails = true; @endphp
                        <div><strong>Profundidad:</strong> {{ $product->depth_spec }} cm</div>
                    @endif
                    @if(!empty($product->capacity))
                        @php $hasDetails = true; @endphp
                        <div><strong>Capacidad:</strong> {{ $product->capacity }}</div>
                    @endif
                    @if(!empty($product->pieces_count))
                        @php $hasDetails = true; @endphp
                        <div><strong>Piezas:</strong> {{ $product->pieces_count }}</div>
                    @endif
                </div>

                @if(!empty($product->technical_specs))
                    @php $hasDetails = true; @endphp
                    <div class="mb-3">
                        <h4 class="font-semibold text-sm">Especificaciones técnicas</h4>
                        <ul class="list-disc list-inside text-xs text-gray-600 space-y-1">
                            @foreach($product->technical_specs as $spec => $value)
                                <li><strong>{{ $spec }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($product->benefits))
                    @php $hasDetails = true; @endphp
                    <div class="mb-3">
                        <h4 class="font-semibold text-sm">Beneficios</h4>
                        <p class="text-xs text-gray-600 line-clamp-2">{{ $product->benefits }}</p>
                    </div>
                @endif

                @if(!empty($product->materials))
                    @php $hasDetails = true; @endphp
                    <div class="mb-3">
                        <h4 class="font-semibold text-sm">Materiales</h4>
                        <p class="text-xs text-gray-600 line-clamp-2">{{ $product->materials }}</p>
                    </div>
                @endif

                @unless($hasDetails)
                    <p class="text-xs text-gray-500">No hay detalles técnicos disponibles para este producto.</p>
                @endunless
            </div>

            <!-- Botón para Ver Ficha Técnica Completa en PDF -->
            <div class="mb-6">
                <button id="datasheet-btn" type="button" data-view-url="{{ route('products.datasheet.view', $product->slug) }}" data-download-url="{{ route('products.datasheet.download', $product->slug) }}" class="w-full inline-flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-lg transition">
                    <i class="fas fa-file-pdf"></i> Ficha Técnica
                </button>
            </div>

            <!-- Modal: Vista previa de la ficha técnica -->
            <div id="datasheet-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-60">
                <div class="bg-white w-11/12 md:w-3/4 lg:w-2/3 h-5/6 rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between px-4 py-3 border-b">
                        <div class="font-bold">Ficha Técnica - {{ $product->name }}</div>
                        <div class="flex items-center gap-2">
                            <a id="datasheet-download" href="#" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-3 rounded text-sm" target="_blank" rel="noopener">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <button type="button" class="datasheet-close inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-gray-100" aria-label="Cerrar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 bg-white relative">
                        <div id="datasheet-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                            <div class="text-center">
                                <i class="fas fa-spinner fa-spin text-4xl text-blue-600 mb-2"></i>
                                <p class="text-gray-600">Cargando ficha técnica...</p>
                            </div>
                        </div>
                        <iframe id="datasheet-iframe" src="" frameborder="0" class="w-full h-full" style="display: none;"></iframe>
                    </div>
                </div>
            </div>

            @auth
                @if(auth()->user()->isAdmin())
                    {{-- Admin solo ve información, sin opciones de cotización --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Vista de Administrador:</strong> Solo visualización del producto.
                        </p>
                    </div>
                @else
                    {{-- Clientes pueden solicitar cotización --}}
                    @if($product->stock_quantity > 0)
                        <div class="mb-6">
                            <!-- Botón de Solicitar Cotización -->
                            <a href="{{ route('quotations.create') }}?product_id={{ $product->id }}&quantity=1" class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition text-center">
                                <i class="fas fa-file-invoice-dollar mr-2"></i> Solicitar Cotización
                            </a>
                        </div>
                    @else
                        <div class="mb-6">
                            <p class="text-red-600 font-bold text-lg mb-4">No disponible</p>
                            <button type="button" class="w-full bg-gray-300 text-gray-600 font-bold py-3 px-4 rounded-lg cursor-not-allowed" disabled>
                                <i class="fas fa-file-invoice-dollar mr-2"></i> Cotizar
                            </button>
                        </div>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-yellow w-full text-center block py-3 mb-4">
                    <i class="fas fa-lock mr-2"></i> Inicia sesión para cotizar
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('datasheet-btn');
    const modal = document.getElementById('datasheet-modal');
    const iframe = document.getElementById('datasheet-iframe');
    const loading = document.getElementById('datasheet-loading');
    const downloadLink = document.getElementById('datasheet-download');
    const closeButtons = document.querySelectorAll('.datasheet-close');

    if (!btn || !modal || !iframe) {
        console.error('Elementos del modal no encontrados');
        return;
    }

    btn.addEventListener('click', function () {
        const viewUrl = btn.dataset.viewUrl;
        const downloadUrl = btn.dataset.downloadUrl;
        
        if (!viewUrl || !downloadUrl) {
            console.error('URLs no encontradas en el botón');
            alert('Error: No se pudo cargar la ficha técnica. URLs no configuradas.');
            return;
        }
        
        console.log('Abriendo modal con URL:', viewUrl);
        
        // Mostrar modal y loading
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        if (loading) loading.style.display = 'flex';
        iframe.style.display = 'none';
        
        // Configurar iframe
        iframe.src = viewUrl;
        downloadLink.setAttribute('href', downloadUrl);
        
        // Escuchar cuando el iframe carga
        iframe.onload = function() {
            console.log('PDF cargado correctamente');
            if (loading) loading.style.display = 'none';
            iframe.style.display = 'block';
        };
        
        // Timeout de seguridad por si no carga
        setTimeout(function() {
            if (iframe.style.display === 'none') {
                console.warn('El PDF tardó demasiado en cargar, mostrando de todos modos');
                if (loading) loading.style.display = 'none';
                iframe.style.display = 'block';
            }
        }, 3000);
    });

    closeButtons.forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    // Cerrar al hacer clic fuera del contenido
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        iframe.src = '';
        iframe.style.display = 'none';
        if (loading) loading.style.display = 'flex';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush
