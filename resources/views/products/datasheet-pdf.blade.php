<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica - {{ $product->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background: #fff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        header {
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .header-title {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
        }
        
        .header-subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }
        
        .product-image {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .product-image img {
            max-width: 300px;
            max-height: 300px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            background-color: #e0f2fe;
            color: #1e3a8a;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-left: 4px solid #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section-content {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 3px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-label {
            font-weight: bold;
            color: #1e3a8a;
            min-width: 150px;
        }
        
        .info-value {
            color: #555;
            flex: 1;
        }
        
        .specs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .spec-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 3px;
        }
        
        .spec-name {
            font-weight: bold;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .spec-value {
            color: #555;
            font-size: 13px;
        }
        
        .text-content {
            line-height: 1.7;
            color: #555;
            text-align: justify;
        }
        
        ul, ol {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        
        li {
            margin-bottom: 8px;
            color: #555;
        }
        
        footer {
            border-top: 2px solid #e2e8f0;
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        table th {
            background-color: #1e3a8a;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        table td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        
        table tr:nth-child(even) {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <header>
            <div class="header-title">FICHA TÉCNICA</div>
            <div class="header-subtitle">Documento técnico detallado del producto</div>
        </header>

        <!-- Imagen del Producto -->
        @if($product->image_url)
            <div class="product-image">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
        @endif

        <!-- Información General -->
        <section class="section">
            <div class="section-title">Información General</div>
            <div class="section-content">
                <div class="info-row">
                    <span class="info-label">Nombre del Producto:</span>
                    <span class="info-value">{{ $product->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Código SKU:</span>
                    <span class="info-value">{{ $product->sku ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Categoría:</span>
                    <span class="info-value">{{ $product->category->name ?? 'No asignada' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Marca:</span>
                    <span class="info-value">{{ $product->brand ?? 'No especificada' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Precio Unitario:</span>
                    <span class="info-value">${{ number_format($product->price, 2, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Unidad de Venta:</span>
                    <span class="info-value">{{ ucfirst($product->unit) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado:</span>
                    <span class="info-value">{{ ucfirst($product->status) }}</span>
                </div>
            </div>
        </section>

        <!-- Descripción General -->
        @if($product->description)
            <section class="section">
                <div class="section-title">Descripción del Producto</div>
                <div class="section-content">
                    <p class="text-content">{{ $product->description }}</p>
                </div>
            </section>
        @endif

        <!-- Características Técnicas del Producto -->
        @php
            $hasTechSpecs = !empty($product->color) || !empty($product->performance) || !empty($product->material_type) 
                         || !empty($product->weight_spec) || !empty($product->accessories) || !empty($product->warranty)
                         || !empty($product->package_content) || !empty($product->model_spec) || !empty($product->height_spec)
                         || !empty($product->width_spec) || !empty($product->length_spec) || !empty($product->depth_spec)
                         || !empty($product->capacity) || !empty($product->pieces_count);
        @endphp
        
        @if($hasTechSpecs)
            <section class="section">
                <div class="section-title">Características Técnicas</div>
                <div class="section-content">
                    <table style="border: none; background: none;">
                        <tr style="border: none;">
                            <td style="border: none; vertical-align: top; width: 50%; padding: 0 10px 0 0;">
                                @if(!empty($product->color))
                                    <div class="info-row"><span class="info-label">Color:</span><span class="info-value">{{ $product->color }}</span></div>
                                @endif
                                @if(!empty($product->performance))
                                    <div class="info-row"><span class="info-label">Rendimiento:</span><span class="info-value">{{ $product->performance }}</span></div>
                                @endif
                                @if(!empty($product->material_type))
                                    <div class="info-row"><span class="info-label">Material:</span><span class="info-value">{{ $product->material_type }}</span></div>
                                @endif
                                @if(!empty($product->weight_spec))
                                    <div class="info-row"><span class="info-label">Peso:</span><span class="info-value">{{ $product->weight_spec }}</span></div>
                                @endif
                                @if(!empty($product->accessories))
                                    <div class="info-row"><span class="info-label">Accesorios:</span><span class="info-value">{{ $product->accessories }}</span></div>
                                @endif
                                @if(!empty($product->warranty))
                                    <div class="info-row"><span class="info-label">Garantía:</span><span class="info-value">{{ $product->warranty }}</span></div>
                                @endif
                                @if(!empty($product->package_content))
                                    <div class="info-row"><span class="info-label">Empaque:</span><span class="info-value">{{ $product->package_content }}</span></div>
                                @endif
                            </td>
                            <td style="border: none; vertical-align: top; width: 50%; padding: 0 0 0 10px;">
                                @if(!empty($product->model_spec))
                                    <div class="info-row"><span class="info-label">Modelo:</span><span class="info-value">{{ $product->model_spec }}</span></div>
                                @endif
                                @if(!empty($product->height_spec))
                                    <div class="info-row"><span class="info-label">Alto:</span><span class="info-value">{{ $product->height_spec }} cm</span></div>
                                @endif
                                @if(!empty($product->width_spec))
                                    <div class="info-row"><span class="info-label">Ancho:</span><span class="info-value">{{ $product->width_spec }} cm</span></div>
                                @endif
                                @if(!empty($product->length_spec))
                                    <div class="info-row"><span class="info-label">Largo:</span><span class="info-value">{{ $product->length_spec }} cm</span></div>
                                @endif
                                @if(!empty($product->depth_spec))
                                    <div class="info-row"><span class="info-label">Profundidad:</span><span class="info-value">{{ $product->depth_spec }} cm</span></div>
                                @endif
                                @if(!empty($product->capacity))
                                    <div class="info-row"><span class="info-label">Capacidad:</span><span class="info-value">{{ $product->capacity }}</span></div>
                                @endif
                                @if(!empty($product->pieces_count))
                                    <div class="info-row"><span class="info-label">Piezas:</span><span class="info-value">{{ $product->pieces_count }}</span></div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        @endif
        @if(!empty($product->technical_specs))
            <section class="section">
                <div class="section-title">Especificaciones Técnicas</div>
                <div class="section-content">
                    <div class="specs-grid">
                        @foreach($product->technical_specs as $spec => $value)
                            <div class="spec-item">
                                <div class="spec-name">{{ $spec }}</div>
                                <div class="spec-value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Dimensiones y Peso -->
        @if($product->dimensions || $product->weight)
            <section class="section">
                <div class="section-title">Dimensiones y Peso</div>
                <div class="section-content">
                    @if($product->dimensions)
                        <div class="info-row">
                            <span class="info-label">Dimensiones:</span>
                            <span class="info-value">{{ $product->dimensions }}</span>
                        </div>
                    @endif
                    @if($product->weight)
                        <div class="info-row">
                            <span class="info-label">Peso:</span>
                            <span class="info-value">{{ $product->weight }} kg</span>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- Materiales de Composición -->
        @if($product->materials)
            <section class="section">
                <div class="section-title">Materiales de Composición</div>
                <div class="section-content text-content">
                    {{ $product->materials }}
                </div>
            </section>
        @endif

        <!-- Beneficios del Producto -->
        @if($product->benefits)
            <section class="section">
                <div class="section-title">Beneficios Principal</div>
                <div class="section-content text-content">
                    {{ $product->benefits }}
                </div>
            </section>
        @endif

        <!-- Uso Previsto -->
        @if($product->intended_use)
            <section class="section">
                <div class="section-title">Uso Previsto y Aplicaciones</div>
                <div class="section-content text-content">
                    {{ $product->intended_use }}
                </div>
            </section>
        @endif

        <!-- Otras Cualidades -->
        @if($product->other_qualities)
            <section class="section">
                <div class="section-title">Otras Cualidades y Propiedades</div>
                <div class="section-content text-content">
                    {{ $product->other_qualities }}
                </div>
            </section>
        @endif

        <!-- Especificaciones Detalladas JSON -->
        @if($product->detailed_specs)
            <section class="section">
                <div class="section-title">Especificaciones Detalladas</div>
                <div class="section-content">
                    @php
                        $specs = $product->detailed_specs;
                        $specsArray = is_array($specs) ? $specs : (is_object($specs) ? (array)$specs : []);
                        $midpoint = ceil(count($specsArray) / 2);
                        $leftSpecs = array_slice($specsArray, 0, $midpoint, true);
                        $rightSpecs = array_slice($specsArray, $midpoint, null, true);
                    @endphp
                    
                    <table style="border: none; background: none; margin: 0;">
                        <tr style="border: none;">
                            <td style="border: none; vertical-align: top; width: 50%; padding: 0 10px 0 0;">
                                <table style="width: 100%;">
                                    <tbody>
                                        @foreach($leftSpecs as $key => $value)
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="padding: 8px; background-color: #f8fafc; font-weight: bold; width: 45%;">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </td>
                                                <td style="padding: 8px; text-align: right;">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td style="border: none; vertical-align: top; width: 50%; padding: 0 0 0 10px;">
                                <table style="width: 100%;">
                                    <tbody>
                                        @foreach($rightSpecs as $key => $value)
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="padding: 8px; background-color: #f8fafc; font-weight: bold; width: 45%;">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </td>
                                                <td style="padding: 8px; text-align: right;">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        @endif

        <!-- Pie de página -->
        <footer>
            <p>Ficha Técnica generada el {{ $generatedAt }}</p>
            <p>Esta información está sujeta a cambios sin previo aviso. Consulte con el proveedor para detalles adicionales.</p>
        </footer>
    </div>
</body>
</html>
