#!/bin/bash

# Script para configurar rápidamente el proyecto Laravel

echo "========================================"
echo "Configurando Salinas Constructor"
echo "========================================"

echo ""
echo "1. Instalando dependencias de Composer..."
composer install

echo ""
echo "2. Generando clave de aplicación..."
php artisan key:generate

echo ""
echo "3. Ejecutando migraciones..."
php artisan migrate

echo ""
echo "4. Creando usuario administrador..."
php artisan db:seed --class=AdminUserSeeder

echo ""
echo "========================================"
echo "¡Configuración completada!"
echo "========================================"
echo ""
echo "Para iniciar el servidor, ejecuta:"
echo "php artisan serve"
echo ""
echo "Acceso de administrador:"
echo "Email: vfjunior117@gmail.com"
echo "Contraseña: 9317anm"
echo ""
echo "URL: http://localhost:8000"
