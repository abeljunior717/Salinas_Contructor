# 🏗️ Salinas Constructor - Instalación y Ejecución

## 📋 Requisitos Previos

- PHP 8.2 o superior
- Composer
- MySQL/MariaDB
- Laragon (ya instalado en tu sistema)

---

## 🚀 Pasos de Instalación

### 1. Navegar al proyecto

```bash
cd c:\laragon\www\salinas
```

### 2. Instalar dependencias (si aún no están instaladas)

```bash
composer install
```

### 3. Configurar archivo .env

Si no existe, copia `.env.example`:

```bash
copy .env.example .env
php artisan key:generate
```

Edita `.env` y configura:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salinas_constructor
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear base de datos

En phpMyAdmin o terminal MySQL:

```sql
CREATE DATABASE salinas_constructor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```

### 6. Ejecutar seeders (cargar datos de ejemplo)

```bash
php artisan db:seed
```

Esto creará:
- ✅ **Admin**: vfjunior117@gmail.com / 9317anm
- ✅ **9 Categorías** de productos
- ✅ **10 Productos** de ejemplo
- ✅ **3 Noticias** de ejemplo

### 7. Iniciar servidor Laravel

```bash
php artisan serve
```

La aplicación estará disponible en: **http://localhost:8000**

---

## 🔐 Credenciales de Acceso

### Administrador
```
Email: vfjunior117@gmail.com
Contraseña: 9317anm
```

### Cliente
Crea una nueva cuenta en `http://localhost:8000/register` con:
- Cualquier nombre
- Cualquier email (MENOS vfjunior117@gmail.com)
- Contraseña personalizada

Se asignará automáticamente como cliente.

ejemplo 
Email: delfin1@gmail.com
Contraseña: 12345678

---

## 📱 URLs Principales

| Página | URL |
|--------|-----|
| **Inicio** | http://localhost:8000 |
| **Catálogo de Productos** | http://localhost:8000/productos |
| **Noticias** | http://localhost:8000/noticias |
| **Login** | http://localhost:8000/login |
| **Registro** | http://localhost:8000/register |
| **Mis Cotizaciones** | http://localhost:8000/cotizaciones |
| **Nueva Cotización** | http://localhost:8000/cotizaciones/crear |
| **Admin Dashboard** | http://localhost:8000/admin/dashboard |
| **Client Dashboard** | http://localhost:8000/client/dashboard |

---

## 🎨 Características Implementadas

### ✅ Autenticación
- Registro de usuarios
- Login seguro
- Rol automático: vfjunior117@gmail.com = Admin, otros = Cliente

### ✅ Catálogo de Productos
- Listado de productos con paginación
- Filtros por categoría
- Búsqueda de productos
- Detalles del producto
- Badges de disponibilidad (Disponible/Agotado)

### ✅ Sistema de Cotizaciones
- Crear cotizaciones con múltiples productos
- Historial de cotizaciones
- Cálculo automático de IVA (19%)
- Vista detallada de cotizaciones
- Estados: Pendiente, Aceptada, Rechazada, Expirada

### ✅ Noticias/Blog
- Listado de noticias publicadas
- Detalle de noticias
- Contador de visitas
- Noticias relacionadas
- Últimas noticias en inicio

### ✅ Diseño
- Interfaz moderna con Tailwind CSS
- Fondo azul claro (celeste)
- Botones amarillos dorados
- Tarjetas de productos responsivas
- Navegación intuitiva
- Footer con información

---

## 🛠️ Estructura del Proyecto

```
app/
├── Models/
│   ├── User.php                 (Usuario con roles)
│   ├── Product.php              (Productos)
│   ├── Category.php             (Categorías)
│   ├── Quotation.php            (Cotizaciones)
│   ├── QuotationItem.php        (Items de cotización)
│   └── News.php                 (Noticias)
└── Http/
    ├── Controllers/
    │   ├── Auth/
    │   │   ├── AuthenticatedSessionController.php
    │   │   └── RegisteredUserController.php
    │   ├── ProductController.php
    │   ├── QuotationController.php
    │   └── NewsController.php
    └── Middleware/
        └── IsAdmin.php

database/
├── migrations/          (Esquemas de tablas)
└── seeders/             (Datos de ejemplo)
    ├── AdminUserSeeder.php
    ├── CategorySeeder.php
    ├── ProductSeeder.php
    └── NewsSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php    (Layout base)
├── products/
│   ├── index.blade.php
│   └── show.blade.php
├── quotations/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── create.blade.php
├── news/
│   ├── index.blade.php
│   └── show.blade.php
└── welcome_new.blade.php
```

---

## 📝 Próximas Funcionalidades (Fase 2)

- [ ] Panel de administración completo
- [ ] Gestión de productos (CRUD)
- [ ] Gestión de categorías (CRUD)
- [ ] Gestión de noticias (CRUD)
- [ ] Aprobación de cotizaciones (Admin)
- [ ] Carrito de compras
- [ ] Exportar cotizaciones a PDF
- [ ] Email de confirmación de cotización
- [ ] Sistema de descuentos
- [ ] Reportes y estadísticas

---

## 🆘 Solución de Problemas

### Error: "php no se reconoce"

Si PHP no está en el PATH de Windows:

```bash
# Usar Laragon para ejecutar comandos
"C:\laragon\bin\php\php-8.x-x64\php.exe" artisan serve
```

O agregar Laragon al PATH:
- Carpeta: `C:\laragon\bin\php\php-8.x-x64\`

### Error: "Base de datos no existe"

```bash
# Crear la base de datos
php artisan migrate --seed
```

### Error: "No hay datos en el catálogo"

```bash
# Ejecutar seeders nuevamente
php artisan db:seed
```

### Limpiar caché

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📞 Soporte

Para más información sobre Laravel:
- [Laravel Docs](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Font Awesome Icons](https://fontawesome.com)

---

**¡Listo! Tu aplicación Salinas Constructor está funcionando.** ✅
