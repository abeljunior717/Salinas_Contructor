@extends('layouts.app')

@section('title', 'Crear Cotización')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Crear Nueva Cotización</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <form action="{{ route('quotations.store') }}" method="POST" class="col-span-1 lg:col-span-2 bg-white rounded-lg p-8">
            @csrf

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Selecciona Productos</h2>
                <div id="items-container" class="space-y-4">
                    <div class="item-row flex items-center gap-4 p-4 bg-gray-50 rounded">
                        <div class="w-20">
                            <img src="{{ isset($preselected) ? ($products->firstWhere('id', $preselected)->image_url ?? 'https://via.placeholder.com/80') : 'https://via.placeholder.com/80' }}" alt="thumb" class="w-20 h-20 object-cover rounded" id="img_0">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold mb-2">Producto</label>
                            <select name="items[0][product_id]" id="product_select_0" class="w-full px-4 py-2 border rounded product-select" required>
                                <option value="">-- Selecciona un producto --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}" data-price="{{ $product->price }}" data-image="{{ $product->image_url ?? 'https://via.placeholder.com/80' }}" {{ (isset($preselected) && $preselected == $product->id) ? 'selected' : '' }} {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                        {{ $product->name }} - ${{ number_format($product->price, 0, ',', '.') }} {{ $product->stock_quantity == 0 ? '(No disponible)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-28">
                            <label class="block text-sm font-bold mb-2">Precio</label>
                            <div class="text-gray-800 font-semibold" id="price_0">$0.00</div>
                        </div>
                        <div class="w-24">
                            <label class="block text-sm font-bold mb-2">Cantidad</label>
                            <input type="number" name="items[0][quantity]" id="qty_input_0" class="w-full px-4 py-2 border rounded item-quantity" 
                                   value="{{ $quantity ?? 1 }}" min="1" required>
                        </div>
                        <div class="w-28">
                            <label class="block text-sm font-bold mb-2">Subtotal</label>
                            <div class="text-gray-800 font-semibold" id="subtotal_0">$0.00</div>
                        </div>
                        <div class="flex items-end">
                            <button type="button" class="btn-primary remove-item hidden">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="btn-primary mt-4">
                    <i class="fas fa-plus mr-2"></i> Agregar otro producto
                </button>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold mb-2">Notas adicionales</label>
                <textarea name="notes" rows="4" class="w-full px-4 py-2 border rounded"
                          placeholder="Escribe tus observaciones o requisitos especiales..."></textarea>
            </div>

            <div class="flex gap-4">
                @if(isset($guestPreview) && $guestPreview && !auth()->check())
                    <a href="{{ route('register') }}" class="btn-yellow">
                        <i class="fas fa-user-plus mr-2"></i> Crear Cuenta para Cotizar
                    </a>
                    <a href="{{ route('login') }}" class="text-sky-700 self-center underline">¿Ya tienes cuenta? Inicia sesión</a>
                @else
                    <button type="submit" class="btn-yellow">
                        <i class="fas fa-check mr-2"></i> Crear Cotización
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left mr-2"></i> Cancelar
                    </a>
                @endif
            </div>
        </form>

        <!-- Resumen a la derecha -->
        <aside class="bg-white rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-bold mb-4">Resumen de Cotización</h2>
            <div id="summary-content">
                <p class="text-gray-600 mb-2">Total Estimado</p>
                <div class="text-2xl font-bold mb-4" id="summary-total">$0.00</div>

                <p class="text-sm text-gray-600">Un asesor de ventas se pondrá en contacto contigo para confirmar precios, disponibilidad y costos de envío.</p>

                @if(!auth()->check())
                    <p class="text-gray-500 text-sm mt-4">Debes tener una cuenta para enviar una cotización.</p>
                    <a href="{{ route('register') }}" class="btn-yellow w-full inline-block mt-4 text-center">Crear Cuenta para Cotizar</a>
                    <a href="{{ route('login') }}" class="block text-center text-sky-700 mt-3 underline">¿Ya tienes cuenta? Inicia sesión</a>
                @else
                    <p class="text-gray-500 text-sm mt-4">Revisa tu selección y crea la cotización.</p>
                @endif
            </div>
        </aside>
    </div>
</div>

@push('scripts')
<script>
    // JS para manejar filas con imagen, precio, cantidad y subtotal, y resumen total
    let itemCount = 1;

    function formatCurrency(n) {
        return '$' + Number(n).toFixed(2);
    }

    function updateRow(row, index) {
        const select = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.item-quantity');
        const priceEl = row.querySelector('[id^="price_"]');
        const subtotalEl = row.querySelector('[id^="subtotal_"]');
        const imgEl = row.querySelector('img');

        if (!select) return;
        const option = select.options[select.selectedIndex];
        const price = parseFloat(option ? option.getAttribute('data-price') || 0 : 0);
        const image = option ? option.getAttribute('data-image') || '' : '';
        const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
        if (priceEl) priceEl.textContent = formatCurrency(price);
        if (subtotalEl) subtotalEl.textContent = formatCurrency(price * qty);
        if (imgEl && image) imgEl.src = image;
    }

    function updateSummary() {
        const subtotalEls = document.querySelectorAll('[id^="subtotal_"]');
        let total = 0;
        subtotalEls.forEach(el => {
            const n = parseFloat(el.textContent.replace(/[^0-9.-]+/g, '')) || 0;
            total += n;
        });
        const totalEl = document.getElementById('summary-total');
        if (totalEl) totalEl.textContent = formatCurrency(total);
    }

    function attachRowListeners(row) {
        const select = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.item-quantity');
        const removeBtn = row.querySelector('.remove-item');

        if (select) {
            select.addEventListener('change', function() {
                updateRow(row);
                updateSummary();
            });
        }
        if (qtyInput) {
            qtyInput.addEventListener('input', function() {
                updateRow(row);
                updateSummary();
            });
        }
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                row.remove();
                updateRemoveButtons();
                updateSummary();
            });
        }
    }

    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newItem = document.createElement('div');
        newItem.className = 'item-row flex items-center gap-4 p-4 bg-gray-50 rounded';
        newItem.innerHTML = `
            <div class="w-20">
                <img src="https://via.placeholder.com/80" alt="thumb" class="w-20 h-20 object-cover rounded" id="img_${itemCount}">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-bold mb-2">Producto</label>
                <select name="items[${itemCount}][product_id]" class="w-full px-4 py-2 border rounded product-select" required>
                    <option value="">-- Selecciona un producto --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}" data-price="{{ $product->price }}" data-image="{{ $product->image_url ?? 'https://via.placeholder.com/80' }}" {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                            {{ $product->name }} - ${{ number_format($product->price, 0, ',', '.') }} {{ $product->stock_quantity == 0 ? '(No disponible)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-28">
                <label class="block text-sm font-bold mb-2">Precio</label>
                <div class="text-gray-800 font-semibold" id="price_${itemCount}">$0.00</div>
            </div>
            <div class="w-24">
                <label class="block text-sm font-bold mb-2">Cantidad</label>
                <input type="number" name="items[${itemCount}][quantity]" id="qty_input_${itemCount}" class="w-full px-4 py-2 border rounded item-quantity" value="1" min="1" required>
            </div>
            <div class="w-28">
                <label class="block text-sm font-bold mb-2">Subtotal</label>
                <div class="text-gray-800 font-semibold" id="subtotal_${itemCount}">$0.00</div>
            </div>
            <div class="flex items-end">
                <button type="button" class="btn-primary remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        container.appendChild(newItem);
        attachRowListeners(newItem);
        updateRemoveButtons();
        itemCount++;
    });

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(btn => btn.classList.add('hidden'));
        if (document.querySelectorAll('.item-row').length > 1) {
            removeButtons.forEach(btn => btn.classList.remove('hidden'));
        }
    }

    // Delegated click for remove (safety)
    document.getElementById('items-container').addEventListener('click', function(e) {
        const rem = e.target.closest('.remove-item');
        if (rem) {
            const row = rem.closest('.item-row');
            if (row) {
                row.remove();
                updateRemoveButtons();
                updateSummary();
            }
        }
    });

    // Attach listeners to existing rows and initialize values
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach((row, idx) => {
            attachRowListeners(row);
            updateRow(row, idx);
        });
        updateRemoveButtons();
        updateSummary();
    });

    // Form submit validation
    document.querySelector('form[action="{{ route('quotations.store') }}"]').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('.item-row');
        let invalid = [];

        rows.forEach((row, idx) => {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.item-quantity');
            const prodId = select ? select.value : null;
            const qty = qtyInput ? parseInt(qtyInput.value) : 0;
            if (!prodId) return;
            const option = select.options[select.selectedIndex];
            const stock = option ? parseInt(option.getAttribute('data-stock') || 0) : 0;

            if (stock <= 0) {
                invalid.push(`El producto "${option.text}" no está disponible.`);
            } else if (qty > stock) {
                invalid.push(`La cantidad solicitada para "${option.text}" excede el stock disponible (${stock}).`);
            }
        });

        if (invalid.length > 0) {
            e.preventDefault();
            alert(invalid.join('\n'));
        }
    });
</script>
@endpush
@endsection
