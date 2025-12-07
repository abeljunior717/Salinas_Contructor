# Salinas Constructor - Configuración de Autenticación

## Información del Proyecto

Este proyecto Laravel implementa un sistema de autenticación con roles de usuario:

- **Administrador**: Solo `vfjunior117@gmail.com` con contraseña `9317anm`
- **Clientes**: Cualquier otro correo registrado

## Pasos para Configurar

### 1. Instalar dependencias
```bash
composer install
```

### 2. Crear archivo .env
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configurar la base de datos
Edita el archivo `.env` con tus credenciales de base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salinas_constructor
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Ejecutar migraciones
```bash
php artisan migrate
```

### 5. Ejecutar seeders (crear administrador)
```bash
php artisan db:seed --class=AdminUserSeeder
```

O ejecutar todos los seeders:
```bash
php artisan db:seed
```

### 6. Iniciar el servidor
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## Acceso

### Para Administrador
- **Email**: `vfjunior117@gmail.com`
- **Contraseña**: `9317anm`
- **URL**: `http://localhost:8000/login`

### Para Clientes
- Ir a `http://localhost:8000/register`
- Crear una cuenta con cualquier email (NO sea vfjunior117@gmail.com)
- Se asignará automáticamente como cliente

## Rutas Disponibles

| Ruta | Descripción |
|------|-------------|
| `/` | Página de inicio |
| `/register` | Formulario de registro |
| `/login` | Formulario de login |
| `/logout` | Cerrar sesión (POST) |
| `/admin/dashboard` | Panel de administrador (solo para admins) |
| `/client/dashboard` | Panel del cliente (usuarios autenticados) |

## Estructura de Archivos Modificados

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       ├── AuthenticatedSessionController.php (nuevo)
│   │       └── RegisteredUserController.php (modificado)
│   └── Middleware/
│       └── IsAdmin.php (nuevo)
├── Models/
│   └── User.php (modificado)

bootstrap/
└── app.php (modificado - registro de middleware)

database/
├── migrations/
│   └── 2025_11_24_000000_add_role_to_users_table.php (nuevo)
└── seeders/
    ├── AdminUserSeeder.php (modificado)
    └── DatabaseSeeder.php (modificado)

resources/views/
├── auth/
│   ├── login.blade.php (nuevo)
│   └── register.blade.php (nuevo)
├── admin/
│   └── dashboard.blade.php (nuevo)
└── client/
    └── dashboard.blade.php (nuevo)

routes/
└── web.php (modificado)
```

## Características Implementadas

✅ Registro de usuarios
✅ Login y logout
✅ Sistema de roles (admin/client)
✅ Middleware de autorización para admin
✅ Redirección automática según rol
✅ Dashboards personalizados por rol
✅ Seeder para crear usuario administrador

## Notas de Seguridad

- La contraseña del administrador está hasheada en la base de datos
- Solo el usuario con email `vfjunior117@gmail.com` puede ser administrador
- El middleware `IsAdmin` protege las rutas administrativas
- Las contraseñas se validan con reglas de Laravel
