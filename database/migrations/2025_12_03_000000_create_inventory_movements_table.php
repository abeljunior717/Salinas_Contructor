<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['entrada', 'salida', 'ajuste']); // Tipo de movimiento
            $table->integer('quantity'); // Cantidad (positivo o negativo)
            $table->integer('stock_before'); // Stock antes del movimiento
            $table->integer('stock_after'); // Stock después del movimiento
            $table->text('reason')->nullable(); // Razón del movimiento
            $table->string('reference')->nullable(); // Referencia (ej: factura, pedido)
            $table->timestamps();
        });

        // Agregar campo de stock mínimo a productos
        Schema::table('products', function (Blueprint $table) {
            $table->integer('stock_min')->default(10)->after('stock_quantity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock_min');
        });
    }
};
