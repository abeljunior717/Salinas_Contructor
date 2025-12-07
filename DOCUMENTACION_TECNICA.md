# DOCUMENTACIÓN TÉCNICA DEL PROYECTO
## Salinas Constructor - Sistema de Gestión

---

## 📑 TABLA DE CONTENIDO

1. [Descripción General](#descripción-general)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Base de Datos](#base-de-datos)
4. [Módulos del Sistema](#módulos-del-sistema)
5. [Flujos de Trabajo](#flujos-de-trabajo)
6. [Seguridad](#seguridad)
7. [API y Endpoints](#api-y-endpoints)

---

## 📋 DESCRIPCIÓN GENERAL

### Objetivo del Proyecto
Desarrollar un sistema web completo para la gestión de materiales de construcción, que permita a los clientes consultar productos, solicitar cotizaciones y utilizar herramientas de cálculo, mientras que los administradores pueden gestionar todo el contenido del sitio.

### Problemática que Resuelve
- **Gestión manual de cotizaciones**: El sistema automatiza el proceso de solicitud y aprobación
- **Falta de información de productos**: Fichas técnicas detalladas en PDF
- **Cálculo manual de materiales**: Calculadora integrada
- **Comunicación desorganizada**: Sistema de mensajes centralizado

### Requerimientos Funcionales Cumplidos
✅ Sistema de autenticación con roles (Admin/Cliente)
✅ CRUD completo de productos y categorías
✅ Sistema de cotizaciones con aprobación
✅ Generación de fichas técnicas en PDF
✅ Calculadora de materiales de construcción
✅ Sistema de noticias/blog
✅ Formulario de contacto con gestión de mensajes
✅ Dashboard administrativo
✅ Dashboard de cliente
✅ Sistema de inventario con control de stock

### Requerimientos No Funcionales Cumplidos
✅ Diseño responsivo (mobile-first)
✅ Interfaz intuitiva y moderna
✅ Rendimiento optimizado
✅ Código limpio y documentado
✅ Seguridad (CSRF, autenticación, autorización)

---

## 🏗️ ARQUITECTURA DEL SISTEMA

### Patrón de Diseño: MVC (Model-View-Controller)

```
┌─────────────────────────────────────────────────────────┐
│                       USUARIO                            │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│                    ROUTES (web.php)                      │
│              Define todas las rutas del sistema          │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│                   CONTROLLERS                            │
│  ┌─────────────┐  ┌──────────────┐  ┌───────────────┐  │
│  │   Product   │  │  Quotation   │  │     Admin     │  │
│  │ Controller  │  │  Controller  │  │   Dashboard   │  │
│  └─────────────┘  └──────────────┘  └───────────────┘  │
└───────────┬───────────────┬─────────────────┬───────────┘
            │               │                 │
            ▼               ▼                 ▼
┌─────────────────────────────────────────────────────────┐
│                      MODELS                              │
│  ┌──────┐  ┌──────────┐  ┌──────┐  ┌─────────────┐    │
│  │Product│  │Quotation │  │ User │  │   Message   │    │
│  └──────┘  └──────────┘  └──────┘  └─────────────┘    │
└───────────────────────────┬─────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────┐
│              DATABASE (SQLite)                           │
│  • products  • quotations  • users  • messages          │
└─────────────────────────────────────────────────────────┘
            ▲
            │
┌───────────┴─────────────┐
│        VIEWS            │
│   (Blade Templates)     │
│  • products/*.blade.php │
│  • admin/*.blade.php    │
│  • quotations/*.blade   │
└─────────────────────────┘
```

### Tecnologías Utilizadas

**Backend:**
- Laravel 12.37.0 (Framework PHP)
- PHP 8.3.16
- Composer (Gestor de dependencias)

**Base de Datos:**
- SQLite 3
- Eloquent ORM

**Frontend:**
- Tailwind CSS 3.x
- JavaScript Vanilla
- Font Awesome 6.4.0
- Google Fonts (Inter)

**Librerías Adicionales:**
- barryvdh/laravel-dompdf (Generación de PDF)

---

## 🗄️ BASE DE DATOS

### Diagrama de Entidades

```
┌─────────────┐         ┌──────────────┐         ┌─────────────────┐
│   USERS     │         │   PRODUCTS   │         │   CATEGORIES    │
├─────────────┤         ├──────────────┤         ├─────────────────┤
│ id          │         │ id           │    ┌────│ id              │
│ name        │         │ name         │    │    │ name            │
│ email       │         │ slug         │    │    │ slug            │
│ password    │         │ category_id  ├────┘    │ description     │
│ role        │         │ price        │         └─────────────────┘
└──────┬──────┘         │ stock        │
       │                │ description  │
       │                └──────┬───────┘
       │                       │
       │                       │
       ▼                       ▼
┌─────────────┐         ┌──────────────┐
│ QUOTATIONS  │         │QUOTATION_ITEMS│
├─────────────┤         ├──────────────┤
│ id          │◄────────┤ id           │
│ user_id     │         │ quotation_id │
│ reference   │         │ product_id   ├──────┐
│ status      │         │ quantity     │      │
│ subtotal    │         │ unit_price   │      │
│ tax_amount  │         │ line_total   │      │
│ total       │         └──────────────┘      │
│ notes       │                               │
└─────────────┘                               │
                                              │
┌──────────────┐         ┌──────────────┐    │
│   MESSAGES   │         │     NEWS     │    │
├──────────────┤         ├──────────────┤    │
│ id           │         │ id           │    │
│ name         │         │ title        │    │
│ email        │         │ slug         │    │
│ message      │         │ content      │    │
│ is_read      │         │ excerpt      │    │
└──────────────┘         │ published_at │    │
                         └──────────────┘    │
                                             │
                         ┌───────────────────┘
                         │
                         └──► Relación con Products
```

### Tablas Principales

#### 1. USERS
```sql
- id: INTEGER PRIMARY KEY
- name: VARCHAR(255)
- email: VARCHAR(255) UNIQUE
- password: VARCHAR(255) (Hasheada)
- role: ENUM('admin', 'client') DEFAULT 'client'
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

#### 2. PRODUCTS
```sql
- id: INTEGER PRIMARY KEY
- name: VARCHAR(255)
- slug: VARCHAR(255) UNIQUE
- category_id: INTEGER (FK → categories)
- description: TEXT
- price: DECIMAL(10,2)
- cost: DECIMAL(10,2)
- stock_quantity: INTEGER
- stock_min: INTEGER DEFAULT 10
- unit: VARCHAR(50)
- status: ENUM('disponible', 'agotado')
- image_url: VARCHAR(500)
- technical_specs: JSON (14 campos específicos)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

#### 3. QUOTATIONS
```sql
- id: INTEGER PRIMARY KEY
- user_id: INTEGER (FK → users)
- reference_number: VARCHAR(50) UNIQUE
- status: ENUM('pendiente', 'aceptada', 'rechazada', 'expirada')
- subtotal: DECIMAL(12,2)
- tax_amount: DECIMAL(12,2)
- discount_amount: DECIMAL(12,2)
- total_amount: DECIMAL(12,2)
- notes: TEXT
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

#### 4. QUOTATION_ITEMS
```sql
- id: INTEGER PRIMARY KEY
- quotation_id: INTEGER (FK → quotations)
- product_id: INTEGER (FK → products)
- quantity: INTEGER
- unit_price: DECIMAL(10,2)
- line_total: DECIMAL(12,2)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

#### 5. MESSAGES
```sql
- id: INTEGER PRIMARY KEY
- name: VARCHAR(100)
- email: VARCHAR(100)
- message: TEXT
- is_read: BOOLEAN DEFAULT FALSE
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

#### 6. INVENTORY_MOVEMENTS
```sql
- id: INTEGER PRIMARY KEY
- product_id: INTEGER (FK → products)
- user_id: INTEGER (FK → users)
- type: ENUM('entrada', 'salida', 'ajuste')
- quantity: INTEGER
- stock_before: INTEGER
- stock_after: INTEGER
- reason: TEXT (Nullable)
- reference: VARCHAR(100) (Nullable)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

---

## 🎯 MÓDULOS DEL SISTEMA

### 1. Módulo de Productos

**Controlador:** `ProductController.php`

**Funcionalidades:**
- Listado con filtros y búsqueda
- Vista detallada de producto
- Generación de fichas técnicas PDF

**Rutas:**
```php
GET  /productos                    // Listado
GET  /productos/{slug}             // Detalle
GET  /productos/{slug}/ficha-tecnica  // Descargar PDF
GET  /productos/{slug}/ficha-tecnica/view  // Ver PDF
```

### 2. Módulo de Cotizaciones

**Controlador:** `QuotationController.php`

**Funcionalidades:**
- Solicitud de cotización (clientes)
- Listado de cotizaciones propias
- Visualización de estado
- Aprobación/rechazo (admin)

**Flujo:**
1. Cliente agrega productos a la cotización
2. Se genera referencia única (QT-YYYYMMDD-XXXX)
3. Administrador revisa y aprueba/rechaza
4. Cliente recibe mensaje según estado

**Rutas:**
```php
GET   /cotizaciones                // Listado
GET   /cotizaciones/crear          // Formulario
POST  /cotizaciones                // Guardar
GET   /cotizaciones/{id}           // Ver detalle

// Admin
POST  /admin/cotizaciones/{id}/aprobar    // Aprobar
POST  /admin/cotizaciones/{id}/rechazar   // Rechazar
```

### 3. Módulo de Calculadora

**Controlador:** `CalculatorController.php`

**Funcionalidades:**
- Cálculo de materiales para muros
- Estimación de cemento (bolsas 50kg)
- Estimación de arena (m³)
- Estimación de grava (m³)
- Estimación de varillas de acero

**Fórmulas:**
```
Volumen = Largo × Alto × Espesor

Cemento = Volumen × 7 bolsas/m³ × 1.10 (desperdicio)
Arena = Volumen × 0.56 m³ × 1.10
Grava = Volumen × 0.84 m³ × 1.10

Varillas:
- Verticales = (Largo / 0.30 + 1) × Alto
- Horizontales = (Alto / 0.50 + 1) × Largo
- Total = (Verticales + Horizontales) / 6m por varilla
```

### 4. Módulo de Administración

**Controlador:** `AdminDashboardController.php`

**Funcionalidades:**
- Dashboard con estadísticas
- CRUD de productos
- CRUD de categorías
- CRUD de noticias
- Gestión de cotizaciones
- Gestión de mensajes
- Visualización de usuarios

**Estadísticas mostradas:**
- Total de productos
- Total de categorías
- Total de noticias
- Cotizaciones pendientes
- Mensajes sin leer
- Total de usuarios

### 5. Módulo de Mensajes

**Controlador:** `Admin/MessageController.php`

**Funcionalidades:**
- Recepción de mensajes de contacto
- Marcado como leído/no leído
- Respuesta por email
- Eliminación de mensajes

### 6. Módulo de Inventario

**Controlador:** `Admin/InventoryController.php`

**Funcionalidades:**
- Registro de movimientos (entradas/salidas/ajustes)
- Historial completo de movimientos con filtros
- Alertas automáticas de stock bajo
- Actualización automática de stock de productos
- Dashboard con productos bajo stock mínimo

**Modelo:** `InventoryMovement.php`

**Características:**
```php
// Tipos de movimiento
- ENTRADA: Suma stock (compras, devoluciones de clientes)
- SALIDA: Resta stock (ventas, devoluciones a proveedores)
- AJUSTE: Establece stock nuevo (correcciones de inventario)

// Relaciones
- belongsTo(Product) - Producto afectado
- belongsTo(User) - Usuario que registró el movimiento

// Atributos computados
- typeColor: Verde/Rojo/Amarillo según tipo
- typeIcon: Iconos FontAwesome según tipo
```

**Validaciones:**
- No permite stock negativo en salidas
- Requiere motivo para ajustes importantes
- Tracking completo: stock_before y stock_after
- Transacciones de BD para integridad de datos

**Vistas:**
- `admin/inventory/index.blade.php` - Historial con filtros
- `admin/inventory/create.blade.php` - Registrar movimiento
- `admin/inventory/alerts.blade.php` - Alertas de stock bajo

**Integración:**
- Alerta visual en dashboard admin si hay productos con stock < stock_min
- Card de acceso rápido en panel de gestión
- Notificaciones en tiempo real

---

## 🔄 FLUJOS DE TRABAJO

### Flujo 1: Solicitud de Cotización

```
CLIENTE
  │
  ├─► Navega al catálogo de productos
  │
  ├─► Selecciona producto y hace clic en "Solicitar Cotización"
  │
  ├─► Se redirige al formulario de cotización
  │
  ├─► Agrega productos con cantidades
  │
  ├─► Envía solicitud
  │
  └─► Sistema genera cotización con estado "Pendiente"

ADMINISTRADOR
  │
  ├─► Ve notificación de cotización pendiente en dashboard
  │
  ├─► Revisa los productos solicitados
  │
  ├─► Decide: ¿Aprobar o Rechazar?
  │
  ├─► Si APRUEBA: Estado → "Aceptada"
  │   └─► Cliente ve mensaje: "¡Felicidades! Su cotización ha sido aceptada..."
  │
  └─► Si RECHAZA: Estado → "Rechazada"
      └─► Cliente ve mensaje: "Al parecer su cotización no es apta..."
```

### Flujo 2: Generación de Ficha Técnica

```
USUARIO
  │
  ├─► Ve detalles de un producto
  │
  ├─► Hace clic en "Ficha Técnica"
  │
  └─► Se abre modal con vista previa del PDF

SISTEMA
  │
  ├─► Carga datos del producto desde BD
  │
  ├─► Genera PDF con DomPDF usando plantilla Blade
  │
  ├─► Incluye:
  │   ├─ Información general (nombre, precio, stock)
  │   ├─ 14 campos de especificaciones técnicas
  │   ├─ Descripción detallada
  │   └─ Fecha de generación
  │
  └─► Muestra en iframe o descarga según acción
```

### Flujo 3: Gestión de Inventario

```
ADMINISTRADOR
  │
  ├─► Accede al módulo de inventario desde dashboard
  │
  ├─► Opción 1: Ver Historial
  │   │
  │   ├─► Lista todos los movimientos con paginación
  │   ├─► Aplica filtros (producto, tipo, fechas)
  │   └─► Ve detalles: stock antes/después, usuario, motivo
  │
  ├─► Opción 2: Registrar Movimiento
  │   │
  │   ├─► Selecciona producto
  │   ├─► Elige tipo: ENTRADA / SALIDA / AJUSTE
  │   ├─► Ingresa cantidad
  │   ├─► (Opcional) Agrega motivo y referencia
  │   │
  │   └─► Sistema:
  │       ├─ Valida que no quede stock negativo
  │       ├─ Calcula nuevo stock según tipo
  │       ├─ Registra movimiento en inventory_movements
  │       ├─ Actualiza stock_quantity en products
  │       └─ Usa transacción BD para integridad
  │
  └─► Opción 3: Ver Alertas
      │
      ├─► Sistema consulta: productos donde stock_quantity < stock_min
      ├─► Muestra lista con:
      │   ├─ Stock actual vs mínimo
      │   ├─ Unidades faltantes
      │   ├─ Barra de progreso visual
      │   └─ Botón rápido "Registrar Entrada"
      │
      └─► Admin puede reabastecer directamente

DASHBOARD
  │
  └─► Alerta automática SI hay productos con stock bajo
      ├─ Banner rojo con contador de productos
      └─ Botón "Ver Alertas" → Redirige a inventory/alerts
```

---

## 🔒 SEGURIDAD

### Medidas Implementadas

1. **Autenticación**
   - Hash de contraseñas con bcrypt
   - Sesiones seguras
   - Middleware de autenticación

2. **Autorización**
   - Roles (admin/client)
   - Verificación de permisos en controladores
   - Restricción de rutas por rol

3. **Protección CSRF**
   - Token CSRF en todos los formularios
   - Validación automática por Laravel

4. **Validación de Datos**
   - Validación en backend (Laravel Validation)
   - Validación en frontend (JavaScript)
   - Sanitización de inputs

5. **Protección SQL Injection**
   - Eloquent ORM (prepared statements)
   - Query Builder seguro

### Middleware Aplicado

```php
// En routes/web.php
Route::middleware(['auth'])->group(function () {
    // Rutas protegidas para usuarios autenticados
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Rutas solo para administradores
});
```

---

## 📡 API Y ENDPOINTS

### Rutas Públicas (Sin autenticación)

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/` | Página de inicio |
| GET | `/productos` | Catálogo de productos |
| GET | `/productos/{slug}` | Detalle de producto |
| GET | `/calculadora` | Calculadora de materiales |
| POST | `/calculadora/calcular` | Procesar cálculo |
| GET | `/noticias` | Listado de noticias |
| GET | `/contacto` | Formulario de contacto |
| POST | `/contacto` | Enviar mensaje |
| GET | `/login` | Formulario de login |
| POST | `/login` | Autenticar usuario |
| GET | `/register` | Formulario de registro |
| POST | `/register` | Crear cuenta |

### Rutas de Cliente (Requiere autenticación)

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/cotizaciones` | Mis cotizaciones |
| GET | `/cotizaciones/crear` | Formulario nueva cotización |
| POST | `/cotizaciones` | Guardar cotización |
| GET | `/cotizaciones/{id}` | Ver cotización |
| GET | `/client/dashboard` | Dashboard del cliente |

### Rutas de Administrador (Requiere auth + rol admin)

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/admin/dashboard` | Panel principal |
| GET | `/admin/productos` | Gestión de productos |
| POST | `/admin/productos` | Crear producto |
| PUT | `/admin/productos/{id}` | Actualizar producto |
| DELETE | `/admin/productos/{id}` | Eliminar producto |
| GET | `/admin/cotizaciones` | Todas las cotizaciones |
| POST | `/admin/cotizaciones/{id}/aprobar` | Aprobar cotización |
| POST | `/admin/cotizaciones/{id}/rechazar` | Rechazar cotización |
| GET | `/admin/mensajes` | Gestión de mensajes |
| PATCH | `/admin/mensajes/{id}/leer` | Marcar como leído |
| DELETE | `/admin/mensajes/{id}` | Eliminar mensaje |
| GET | `/admin/noticias` | Gestión de noticias |
| GET | `/admin/categorias` | Gestión de categorías |
| GET | `/admin/usuarios` | Lista de usuarios |
| GET | `/admin/inventario` | Historial de movimientos |
| GET | `/admin/inventario/crear` | Registrar movimiento |
| POST | `/admin/inventario` | Guardar movimiento |
| GET | `/admin/inventario/alertas` | Productos con stock bajo |

---

## 📊 ESTADÍSTICAS Y REPORTES

El sistema incluye dos dashboards con estadísticas:

### Dashboard de Administrador
- Total de productos
- Total de categorías
- Total de noticias
- Cotizaciones pendientes
- Mensajes sin leer
- Total de usuarios
- Alerta visual de productos con stock bajo (si existen)
- Cotizaciones recientes (últimas 5)
- Acceso rápido a módulo de inventario

### Dashboard de Cliente
- Total de cotizaciones realizadas
- Cotizaciones pendientes
- Cotizaciones aceptadas
- Cotizaciones rechazadas
- Historial de cotizaciones

---

## 🎨 DISEÑO Y UX

### Principios de Diseño Aplicados

1. **Minimalismo**: Diseño limpio y moderno
2. **Responsive**: Adaptable a todos los dispositivos
3. **Accesibilidad**: Contraste adecuado, iconos descriptivos
4. **Feedback visual**: Mensajes claros de éxito/error
5. **Navegación intuitiva**: Estructura lógica de menús

### Paleta de Colores

```css
--primary: #3b82f6;        /* Azul principal */
--secondary: #64748b;       /* Gris secundario */
--success: #10b981;         /* Verde éxito */
--warning: #f59e0b;         /* Amarillo advertencia */
--error: #ef4444;           /* Rojo error */
```

---

## 🧪 PRUEBAS Y VALIDACIÓN

### Casos de Prueba Realizados

✅ Registro de usuario nuevo
✅ Login con credenciales correctas/incorrectas
✅ Creación de cotización por cliente
✅ Aprobación de cotización por admin
✅ Rechazo de cotización por admin
✅ Generación de ficha técnica PDF
✅ Cálculo de materiales con diferentes valores
✅ Envío de mensaje de contacto
✅ Filtrado de productos por categoría
✅ Búsqueda de productos
✅ Restricción de acceso según roles
✅ Registro de movimientos de inventario (entrada/salida/ajuste)
✅ Alertas automáticas de stock bajo
✅ Historial completo de movimientos con filtros

---

## 📝 CONCLUSIÓN

El sistema **Salinas Constructor** cumple exitosamente con todos los requerimientos funcionales y no funcionales planteados. Implementa correctamente el patrón MVC usando Laravel como framework backend, integra una base de datos SQLite bien estructurada, y proporciona una interfaz de usuario moderna y responsiva.

Las características destacadas incluyen:
- Sistema de cotizaciones completo con aprobación
- Generación dinámica de fichas técnicas en PDF
- Calculadora especializada de materiales
- Panel de administración robusto
- Sistema de inventario con control de stock y alertas automáticas
- Seguridad implementada en múltiples capas

El código está organizado, documentado y sigue las mejores prácticas de desarrollo web con Laravel.

---

**Fecha de elaboración:** 3 de Diciembre de 2025
**Versión del documento:** 1.0
