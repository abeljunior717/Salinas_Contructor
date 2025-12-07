#!/bin/bash

echo "🔍 VERIFICACIÓN DE INSTALACIÓN - Salinas Constructor"
echo "========================================================"
echo ""

# Verificar PHP
echo "✓ Verificando PHP..."
php -v | head -1

# Verificar Composer
echo ""
echo "✓ Verificando Composer..."
composer --version

# Verificar Laravel
echo ""
echo "✓ Verificando Laravel..."
php artisan --version

# Verificar migraciones
echo ""
echo "✓ Verificando migraciones..."
php artisan migrate:status | head -20

# Verificar base de datos
echo ""
echo "✓ Verificando conexión a base de datos..."
php artisan tinker --execute="echo 'Conexión exitosa!' . PHP_EOL;"

echo ""
echo "========================================================"
echo "✅ VERIFICACIÓN COMPLETADA"
echo ""
echo "📝 Próximos pasos:"
echo "1. Ejecutar migraciones: php artisan migrate"
echo "2. Cargar datos: php artisan db:seed"
echo "3. Iniciar servidor: php artisan serve"
echo "4. Abrir: http://localhost:8000"
echo ""
