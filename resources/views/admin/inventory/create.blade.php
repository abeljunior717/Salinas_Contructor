@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Encabezado -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-clipboard-list mr-2"></i>Registrar Movimiento de Inventario
                </h1>
                <p class="text-gray-600 mt-2">Registra entradas, salidas o ajustes de stock</p>
            </div>

            <!-- Errores -->
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Error:</strong>
                    <ul class="mt-2 ml-6 list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('admin.inventory.store') }}" class="space-y-6">
                @csrf

                <!-- Producto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Producto <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="product_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-stock="{{ $product->stock_quantity }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stock actual: {{ $product->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                    <div id="current-stock-info" class="mt-2 text-sm text-gray-600 hidden">
                        Stock actual: <span id="current-stock" class="font-bold"></span> unidades
                    </div>
                </div>

                <!-- Tipo de movimiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Movimiento <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <input type="radio" id="type_entrada" name="type" value="entrada" 
                                   {{ old('type') == 'entrada' ? 'checked' : '' }}
                                   class="peer hidden" required>
                            <label for="type_entrada" 
                                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-green-50 peer-checked:border-green-500 peer-checked:bg-green-50">
                                <i class="fas fa-arrow-up text-3xl text-green-600 mb-2"></i>
                                <span class="font-medium">Entrada</span>
                                <span class="text-xs text-gray-500">Agregar stock</span>
                            </label>
                        </div>

                        <div>
                            <input type="radio" id="type_salida" name="type" value="salida"
                                   {{ old('type') == 'salida' ? 'checked' : '' }}
                                   class="peer hidden">
                            <label for="type_salida" 
                                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-red-50 peer-checked:border-red-500 peer-checked:bg-red-50">
                                <i class="fas fa-arrow-down text-3xl text-red-600 mb-2"></i>
                                <span class="font-medium">Salida</span>
                                <span class="text-xs text-gray-500">Retirar stock</span>
                            </label>
                        </div>

                        <div>
                            <input type="radio" id="type_ajuste" name="type" value="ajuste"
                                   {{ old('type') == 'ajuste' ? 'checked' : '' }}
                                   class="peer hidden">
                            <label for="type_ajuste" 
                                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
                                <i class="fas fa-edit text-3xl text-yellow-600 mb-2"></i>
                                <span class="font-medium">Ajuste</span>
                                <span class="text-xs text-gray-500">Corregir stock</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Cantidad -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ingrese la cantidad">
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle"></i> 
                        Para ajustes, ingrese el nuevo stock total
                    </p>
                </div>

                <!-- Motivo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Motivo
                    </label>
                    <textarea name="reason" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Describa el motivo del movimiento (opcional)">{{ old('reason') }}</textarea>
                </div>

                <!-- Referencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Referencia/Documento
                    </label>
                    <input type="text" name="reference" value="{{ old('reference') }}" maxlength="100"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ej: Factura #12345, Orden de compra, etc. (opcional)">
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.inventory.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-save mr-2"></i>Registrar Movimiento
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-bold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Información sobre tipos de movimiento:
            </h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li><strong>Entrada:</strong> Se suma la cantidad al stock actual (compras, devoluciones de clientes)</li>
                <li><strong>Salida:</strong> Se resta la cantidad del stock actual (ventas, devoluciones a proveedores)</li>
                <li><strong>Ajuste:</strong> Se establece un nuevo stock total (correcciones por inventario físico)</li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const stockInfo = document.getElementById('current-stock-info');
    const stockSpan = document.getElementById('current-stock');

    productSelect.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            stockSpan.textContent = stock;
            stockInfo.classList.remove('hidden');
        } else {
            stockInfo.classList.add('hidden');
        }
    });
});
</script>
@endsection
