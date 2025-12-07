# ⚡ QUICK START - 5 MINUTOS

## 🚀 Ejecutar esto AHORA en PowerShell:

```powershell
cd c:\laragon\www\salinas
```

### 1️⃣ MIGRACIONES (crear tablas)
```powershell
php artisan migrate
```

**Resultado esperado:**
```
Creating migration table ..................... 10ms DONE
Migrating: 2025_11_24_000000_add_role_to_users_table ................... 10ms DONE
Migrating: 2025_11_24_create_categories_table .......................... 10ms DONE
Migrating: 2025_11_24_create_products_table ............................ 10ms DONE
Migrating: 2025_11_24_create_quotations_table .......................... 10ms DONE
Migrating: 2025_11_24_create_quotation_items_table ..................... 10ms DONE
Migrating: 2025_11_24_create_news_table ............................... 10ms DONE
```

### 2️⃣ CARGAR DATOS (admin, productos, noticias)
```powershell
php artisan db:seed
```

**Resultado esperado:**
```
Seeding: Database\Seeders\AdminUserSeeder
Seeding: Database\Seeders\CategorySeeder
Seeding: Database\Seeders\ProductSeeder
Seeding: Database\Seeders\NewsSeeder
Database seeding completed successfully.
```

### 3️⃣ INICIAR SERVIDOR
```powershell
php artisan serve
```

**Resultado esperado:**
```
Laravel development server started:
  Local: http://127.0.0.1:8000
  Press Ctrl+C to stop the server
```

### 4️⃣ ABRIR EN NAVEGADOR

Copia y pega en tu navegador:

```
http://localhost:8000
```

---

## ✅ LISTO - ¡LA APLICACIÓN ESTÁ CORRIENDO!

---

## 🔐 Credenciales para Login:

**Admin:**
```
Email: vfjunior117@gmail.com
Contraseña: 9317anm
```

**Crear Cliente:**
1. Click en "Registrarse"
2. Usa tu email personal
3. Crea contraseña
4. Se creará como cliente automáticamente

---

## 📍 URLs PRINCIPALES:

| Sección | URL |
|---------|-----|
| 🏠 Inicio | http://localhost:8000 |
| 📦 Productos | http://localhost:8000/productos |
| 📰 Noticias | http://localhost:8000/noticias |
| 📋 Cotizaciones | http://localhost:8000/cotizaciones |
| 🔑 Login | http://localhost:8000/login |
| ✍️ Registro | http://localhost:8000/register |

---

## 🆘 Si algo no funciona:

### Error: "php no se reconoce"
```powershell
# Usar la ruta completa de Laragon
"C:\laragon\bin\php\php-8.2-x64\php.exe" artisan serve
```

### Error: "Base de datos no existe"
```powershell
# Ejecutar migraciones de nuevo
php artisan migrate:fresh --seed
```

### Error: "Clase no encontrada"
```powershell
# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Verificar que todo está bien
```powershell
php artisan migrate:status
php artisan db:seed --verbose
```

---

## 📝 Notas:

- ✅ No hay que crear la base de datos (Laravel lo hace)
- ✅ Todas las tablas se crean automáticamente
- ✅ Los datos de ejemplo se cargan automáticamente
- ✅ El usuario admin se crea automáticamente
- ✅ El servidor corre en http://127.0.0.1:8000 (same as localhost:8000)

---

**¡Presiona Ctrl+C en la terminal para detener el servidor!**

---

**Suerte! 🎉**
