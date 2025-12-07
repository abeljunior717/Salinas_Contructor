# SISTEMA DE INVENTARIO - DOCUMENTACIÓN

## Fecha de Implementación
3 de diciembre de 2024

## Descripción General

Se ha implementado un **Sistema Completo de Control de Inventario** exclusivo para administradores que permite:
- ✅ Control de entradas y salidas de mercancía
- ✅ Historial completo de movimientos
- ✅ Alertas automáticas de stock bajo
- ✅ Registro de ajustes de inventario
- ✅ Seguimiento de stock mínimo por producto

---

## 1. ESTRUCTURA DE LA BASE DE DATOS

### Tabla: `inventory_movements`
Nueva tabla para registrar todos los movimientos de inventario.

```sql
CREATE TABLE inventory_movements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,              -- Producto afectado
    user_id BIGINT NOT NULL,                 -- Usuario que registró el movimiento
    type ENUM('entrada','salida','ajuste'),  -- Tipo de movimiento
    quantity INT NOT NULL,                   -- Cantidad del movimiento
    stock_before INT NOT NULL,               -- Stock antes del movimiento
    stock_after INT NOT NULL,                -- Stock después del movimiento
    reason TEXT NULL,                        -- Motivo del movimiento
    reference VARCHAR(100) NULL,             -- Referencia (factura, orden, etc.)
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Tabla: `products` - Campo Agregado
Se agregó el campo `stock_min` para establecer el stock mínimo de alerta.

```sql
ALTER TABLE products ADD COLUMN stock_min INT DEFAULT 10;
```

---

## 2. MODELOS Y RELACIONES

### Modelo: `InventoryMovement`
**Ubicación:** `app/Models/InventoryMovement.php`

**Relaciones:**
```php
// Relación con Producto
public function product(): BelongsTo
{
    return $this->belongsTo(Product::class);
}

// Relación con Usuario
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

**Atributos Computados:**
```php
// Obtener color según tipo de movimiento
public function getTypeColorAttribute()
{
    return match($this->type) {
        'entrada' => 'green',
        'salida' => 'red',
        'ajuste' => 'yellow',
    };
}

// Obtener icono según tipo
public function getTypeIconAttribute()
{
    return match($this->type) {
        'entrada' => 'arrow-up',
        'salida' => 'arrow-down',
        'ajuste' => 'edit',
    };
}
```

### Modelo: `Product` - Métodos Agregados
**Ubicación:** `app/Models/Product.php`

```php
// Relación con movimientos de inventario
public function inventoryMovements()
{
    return $this->hasMany(InventoryMovement::class);
}

// Verificar si el producto tiene stock bajo
public function isLowStock()
{
    return $this->stock_quantity < $this->stock_min;
}
```

---

## 3. CONTROLADOR

### InventoryController
**Ubicación:** `app/Http/Controllers/Admin/InventoryController.php`

#### Métodos Disponibles:

1. **index()** - Historial de movimientos
   - Lista todos los movimientos con paginación
   - Filtros: producto, tipo, rango de fechas
   - Ruta: `/admin/inventario`

2. **create()** - Formulario de registro
   - Muestra formulario para registrar nuevo movimiento
   - Ruta: `/admin/inventario/crear`

3. **store()** - Guardar movimiento
   - Valida datos
   - Registra movimiento en BD
   - Actualiza stock del producto
   - Utiliza transacciones para integridad
   - Ruta: `POST /admin/inventario`

4. **alerts()** - Alertas de stock bajo
   - Lista productos con stock < stock_min
   - Ordenados por stock ascendente
   - Ruta: `/admin/inventario/alertas`

5. **getStock()** - Obtener stock (AJAX)
   - Retorna stock actual de un producto
   - Ruta: `GET /admin/inventario/stock/{product}`

---

## 4. VISTAS BLADE

### 4.1 Historial de Movimientos
**Archivo:** `resources/views/admin/inventory/index.blade.php`

**Características:**
- Tabla completa de movimientos
- Filtros por: producto, tipo, fechas
- Paginación de resultados
- Muestra: fecha, producto, tipo, cantidades, usuario, motivo
- Botones de acción: Ver Alertas, Registrar Movimiento

### 4.2 Registrar Movimiento
**Archivo:** `resources/views/admin/inventory/create.blade.php`

**Características:**
- Selector visual de tipo de movimiento (cards)
- Tipos disponibles:
  - **Entrada** (verde): Agregar stock
  - **Salida** (rojo): Retirar stock
  - **Ajuste** (amarillo): Corregir stock
- Campos: producto, cantidad, motivo, referencia
- Muestra stock actual al seleccionar producto
- Validación en cliente y servidor

### 4.3 Alertas de Stock Bajo
**Archivo:** `resources/views/admin/inventory/alerts.blade.php`

**Características:**
- Cards visuales para cada producto con stock bajo
- Muestra: stock actual, stock mínimo, unidades faltantes
- Barra de progreso visual del porcentaje de stock
- Botón directo para registrar entrada
- Si no hay alertas, muestra mensaje positivo

---

## 5. RUTAS

**Archivo:** `routes/web.php`

```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Historial de movimientos
    Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory.index');
    
    // Formulario de registro
    Route::get('/inventario/crear', [InventoryController::class, 'create'])->name('inventory.create');
    
    // Guardar movimiento
    Route::post('/inventario', [InventoryController::class, 'store'])->name('inventory.store');
    
    // Alertas de stock bajo
    Route::get('/inventario/alertas', [InventoryController::class, 'alerts'])->name('inventory.alerts');
    
    // Obtener stock (AJAX)
    Route::get('/inventario/stock/{product}', [InventoryController::class, 'getStock'])->name('inventory.stock');
});
```

**Protección:**
- Middleware `auth`: Solo usuarios autenticados
- Middleware `admin`: Solo administradores
- Prefijo: `/admin`

---

## 6. INTEGRACIÓN EN DASHBOARD

### Alerta Visual
Se agregó en el dashboard admin (`resources/views/admin/dashboard.blade.php`) una alerta visual que aparece cuando hay productos con stock bajo:

```blade
@php
    $lowStockProducts = \App\Models\Product::whereColumn('stock_quantity', '<', 'stock_min')
        ->where('is_active', true)
        ->count();
@endphp

@if($lowStockProducts > 0)
    <div class="mb-6 bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-lg shadow-lg p-6">
        <!-- Alerta con contador y botón "Ver Alertas" -->
    </div>
@endif
```

### Card de Acceso Rápido
Se agregó una nueva card en la sección "Gestión Rápida":

```blade
<x-card class="text-center p-8">
    <div class="text-5xl text-indigo-600 mb-4"><i class="fas fa-warehouse"></i></div>
    <h3 class="text-xl font-bold mb-2">Control de Inventario</h3>
    <p class="text-gray-600 text-sm mb-6">Gestionar entradas, salidas y stock de productos.</p>
    <a href="{{ route('admin.inventory.index') }}" class="inline-block btn-yellow px-6 py-2 rounded-lg font-semibold">Ir a Inventario</a>
</x-card>
```

---

## 7. TIPOS DE MOVIMIENTOS

### 7.1 ENTRADA
- **Uso:** Cuando ingresa mercancía nueva
- **Operación:** `stock_nuevo = stock_anterior + cantidad`
- **Ejemplos:**
  - Compra a proveedores
  - Devoluciones de clientes
  - Transferencias desde otras bodegas

### 7.2 SALIDA
- **Uso:** Cuando sale mercancía del inventario
- **Operación:** `stock_nuevo = stock_anterior - cantidad`
- **Validación:** No permite stock negativo
- **Ejemplos:**
  - Ventas a clientes
  - Devoluciones a proveedores
  - Productos dañados o vencidos

### 7.3 AJUSTE
- **Uso:** Para corregir discrepancias de inventario
- **Operación:** `stock_nuevo = cantidad_ingresada`
- **Ejemplos:**
  - Corrección por inventario físico
  - Ajuste por diferencias encontradas
  - Corrección de errores de registro

---

## 8. FLUJO DE USO

### Escenario 1: Registrar Entrada de Mercancía
1. Admin ingresa a `/admin/inventario/crear`
2. Selecciona el producto del dropdown
3. Selecciona tipo "Entrada"
4. Ingresa cantidad recibida
5. Opcionalmente agrega motivo y referencia (ej: "Factura #12345")
6. Clic en "Registrar Movimiento"
7. Sistema registra movimiento y actualiza stock automáticamente

### Escenario 2: Consultar Historial
1. Admin ingresa a `/admin/inventario`
2. Ve tabla con todos los movimientos
3. Opcionalmente aplica filtros:
   - Selecciona producto específico
   - Selecciona tipo de movimiento
   - Define rango de fechas
4. Clic en "Buscar"
5. Ve resultados filtrados con paginación

### Escenario 3: Revisar Alertas de Stock Bajo
1. Admin ve alerta roja en dashboard (si hay productos con stock bajo)
2. Clic en "Ver Alertas" o ingresa a `/admin/inventario/alertas`
3. Ve lista de productos con stock < stock_min
4. Cada card muestra:
   - Stock actual vs stock mínimo
   - Barra de progreso visual
   - Unidades faltantes
5. Clic en "Registrar Entrada" para reabastecer directamente

---

## 9. VALIDACIONES

### En el Controlador (store):
```php
$request->validate([
    'product_id' => 'required|exists:products,id',
    'type' => 'required|in:entrada,salida,ajuste',
    'quantity' => 'required|integer|min:1',
    'reason' => 'nullable|string|max:500',
    'reference' => 'nullable|string|max:100',
]);

// Validación adicional: no permitir stock negativo en salidas
if ($stockAfter < 0) {
    return back()->withErrors([
        'quantity' => 'No hay suficiente stock disponible. Stock actual: ' . $stockBefore
    ])->withInput();
}
```

---

## 10. CARACTERÍSTICAS DE SEGURIDAD

1. **Autenticación Requerida:** Solo usuarios logueados
2. **Autorización por Rol:** Solo administradores (`admin` middleware)
3. **Transacciones de BD:** Garantizan integridad de datos
4. **Validación de Datos:** En cliente y servidor
5. **Protección CSRF:** Token en todos los formularios
6. **Cascada en Eliminaciones:** Si se elimina producto/usuario, se eliminan sus movimientos

---

## 11. MANTENIMIENTO Y FUTURAS MEJORAS

### Posibles Mejoras Futuras:
- [ ] Exportar historial a Excel/PDF
- [ ] Gráficos de movimientos por fecha
- [ ] Envío de emails automáticos cuando stock < mínimo
- [ ] Códigos de barras para productos
- [ ] Movimientos masivos (importar desde CSV)
- [ ] Historial por rango de fechas personalizado
- [ ] Reportes de rotación de inventario
- [ ] Integración con sistema de ventas

---

## 12. COMANDOS ÚTILES

### Ejecutar Migración
```bash
php artisan migrate
```

### Ver Movimientos de un Producto (Tinker)
```bash
php artisan tinker
>>> $product = Product::find(1);
>>> $product->inventoryMovements;
```

### Ver Productos con Stock Bajo (Tinker)
```bash
php artisan tinker
>>> Product::whereColumn('stock_quantity', '<', 'stock_min')->get();
```

### Rollback de Migración (si necesario)
```bash
php artisan migrate:rollback --step=1
```

---

## 13. EJEMPLO DE USO REAL

### Caso: Llega pedido de cemento
1. Proveedor entrega 100 sacos de cemento
2. Admin ingresa a "Registrar Movimiento"
3. Selecciona: 
   - Producto: "Cemento Pacasmayo Tipo I"
   - Tipo: Entrada
   - Cantidad: 100
   - Motivo: "Compra a proveedor Distribuciones ABC"
   - Referencia: "Factura #000123"
4. Sistema registra:
   ```
   stock_before: 15
   stock_after: 115
   type: entrada
   quantity: 100
   ```
5. Si el producto estaba en alertas, desaparece automáticamente

---

## 14. RESOLUCIÓN DE PROBLEMAS

### Error: "No hay suficiente stock disponible"
- **Causa:** Intento de salida mayor al stock actual
- **Solución:** Verificar stock actual o usar "Ajuste" para corregir

### Error: "Migración ya ejecutada"
- **Causa:** Ya existe la tabla inventory_movements
- **Solución:** Verificar con `SHOW TABLES;` en BD

### No aparecen alertas en dashboard
- **Causa:** Ningún producto tiene stock < stock_min
- **Solución:** Verificar valores de stock_min en productos

---

## 15. ARCHIVOS CREADOS/MODIFICADOS

### Archivos Nuevos:
- `database/migrations/2025_12_03_000000_create_inventory_movements_table.php`
- `app/Models/InventoryMovement.php`
- `app/Http/Controllers/Admin/InventoryController.php`
- `resources/views/admin/inventory/index.blade.php`
- `resources/views/admin/inventory/create.blade.php`
- `resources/views/admin/inventory/alerts.blade.php`
- `SISTEMA_INVENTARIO.md` (este documento)

### Archivos Modificados:
- `app/Models/Product.php` (agregadas relaciones y métodos)
- `routes/web.php` (agregadas rutas de inventario)
- `resources/views/admin/dashboard.blade.php` (alerta y card de inventario)

---

## 16. CONCLUSIÓN

El sistema de inventario está **completamente funcional** y listo para usar. Proporciona un control completo sobre el stock de productos, con historial detallado, alertas automáticas y una interfaz intuitiva exclusiva para administradores.

**Recuerda ejecutar la migración antes de usar:**
```bash
cd c:\laragon\www\salinas
php artisan migrate
```

---

**Fecha de Creación:** 3 de diciembre de 2024  
**Versión:** 1.0  
**Desarrollado para:** Salinas Constructor - Sistema de Gestión
