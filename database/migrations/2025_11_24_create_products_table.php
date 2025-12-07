<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('technical_specs')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('unit')->default('saco'); // saco, pieza, m2, etc.
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->nullable()->unique();
            $table->string('image_url')->nullable();
            $table->json('images')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->enum('status', ['disponible', 'agotado', 'descontinuado'])->default('disponible');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
