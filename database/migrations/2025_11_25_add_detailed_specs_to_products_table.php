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
        Schema::table('products', function (Blueprint $table) {
            // Agregar campos para información técnica detallada
            $table->text('benefits')->nullable()->after('dimensions'); // Beneficios del producto
            $table->text('materials')->nullable()->after('benefits'); // Materiales de composición
            $table->text('intended_use')->nullable()->after('materials'); // Uso previsto
            $table->text('other_qualities')->nullable()->after('intended_use'); // Otras cualidades/propiedades
            $table->json('detailed_specs')->nullable()->after('other_qualities'); // Especificaciones detalladas en JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'benefits',
                'materials',
                'intended_use',
                'other_qualities',
                'detailed_specs',
            ]);
        });
    }
};
