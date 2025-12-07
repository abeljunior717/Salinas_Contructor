@extends('layouts.app')

@section('title', 'Editar Producto - Admin')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Editar Producto" subtitle="Actualiza la información y stock del producto." />

    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Nombre Producto</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Slug (URL)</label>
                        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Descripción</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Categoría</label>
                        <select name="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Unidad</label>
                        <input type="text" name="unit" placeholder="ej: pieza, kg, m" value="{{ old('unit', $product->unit) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Precio Venta ($)</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Costo ($)</label>
                        <input type="number" name="cost" step="0.01" value="{{ old('cost', $product->cost) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Stock</label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">URL de Imagen</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Sección de Información Técnica Detallada -->
                <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-600">
                    <h3 class="text-lg font-bold mb-4 text-blue-600">
                        <i class="fas fa-cogs mr-2"></i> Información Técnica Detallada del Producto
                    </h3>

                    <!-- Fila 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Color</label>
                            <input type="text" name="color" placeholder="Ej: Gris, Rojo, Azul..." value="{{ old('color', $product->color ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Rendimiento</label>
                            <input type="text" name="performance" placeholder="Ej: 300 cm², 50 m²..." value="{{ old('performance', $product->performance ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Fila 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Material</label>
                            <input type="text" name="material_type" placeholder="Ej: Acero, Polvo, Cerámica..." value="{{ old('material_type', $product->material_type ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Peso</label>
                            <input type="text" name="weight_spec" placeholder="Ej: 50 kg, 2.5 kg..." value="{{ old('weight_spec', $product->weight_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Fila 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Accesorios</label>
                            <input type="text" name="accessories" placeholder="Ej: No, Incluye aplicador, Incluye brocha..." value="{{ old('accessories', $product->accessories ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Garantía Proveedor</label>
                            <input type="text" name="warranty" placeholder="Ej: 90 días, 1 año, Sin garantía..." value="{{ old('warranty', $product->warranty ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Fila 4 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Contenido del Empaque</label>
                            <input type="text" name="package_content" placeholder="Ej: 1 bulto de 50 kg, 5 piezas..." value="{{ old('package_content', $product->package_content ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Modelo</label>
                            <input type="text" name="model_spec" placeholder="Ej: CPC 30R RS, XYZ-500..." value="{{ old('model_spec', $product->model_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Fila 5: Dimensiones -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Alto (cm)</label>
                            <input type="text" name="height_spec" placeholder="Ej: 61" value="{{ old('height_spec', $product->height_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Ancho (cm)</label>
                            <input type="text" name="width_spec" placeholder="Ej: 43" value="{{ old('width_spec', $product->width_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Largo (cm)</label>
                            <input type="text" name="length_spec" placeholder="Ej: 62" value="{{ old('length_spec', $product->length_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Profundidad (cm)</label>
                            <input type="text" name="depth_spec" placeholder="Ej: 19" value="{{ old('depth_spec', $product->depth_spec ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Fila 6 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Capacidad / Tamaño</label>
                            <input type="text" name="capacity" placeholder="Ej: Resistencia de hasta 300 kg/cm²..." value="{{ old('capacity', $product->capacity ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Número de Piezas</label>
                            <input type="text" name="pieces_count" placeholder="Ej: 1, 5, 10..." value="{{ old('pieces_count', $product->pieces_count ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Información Complementaria -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Beneficios del Producto</label>
                        <textarea name="benefits" id="benefits" rows="2" placeholder="Ej: Resistencia al agua, durabilidad, bajo costo..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('benefits', $product->benefits) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Descripción de Materiales / Composición</label>
                        <textarea name="materials" id="materials" rows="2" placeholder="Ej: Acero galvanizado, pintura epóxica..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('materials', $product->materials) }}</textarea>
                    </div>
                </div>

                <p class="text-xs text-gray-500 bg-yellow-50 px-4 py-2 rounded border border-yellow-200">
                    <i class="fas fa-info-circle mr-1"></i> <strong>Nota:</strong> Rellena todos los campos técnicos disponibles. Esta información aparecerá en la ficha técnica en PDF.
                </p>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Actualizar Producto
                    </button>
                    <a href="{{ route('admin.products') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 rounded-lg transition text-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection