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
            // Agregar campos de información técnica específica
            $table->string('color')->nullable()->after('dimensions');
            $table->string('performance')->nullable()->after('color');
            $table->string('material_type')->nullable()->after('performance');
            $table->string('weight_spec')->nullable()->after('material_type');
            $table->string('accessories')->nullable()->after('weight_spec');
            $table->string('warranty')->nullable()->after('accessories');
            $table->string('package_content')->nullable()->after('warranty');
            $table->string('model_spec')->nullable()->after('package_content');
            $table->string('height_spec')->nullable()->after('model_spec');
            $table->string('width_spec')->nullable()->after('height_spec');
            $table->string('length_spec')->nullable()->after('width_spec');
            $table->string('depth_spec')->nullable()->after('length_spec');
            $table->string('capacity')->nullable()->after('depth_spec');
            $table->string('pieces_count')->nullable()->after('capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'color',
                'performance',
                'material_type',
                'weight_spec',
                'accessories',
                'warranty',
                'package_content',
                'model_spec',
                'height_spec',
                'width_spec',
                'length_spec',
                'depth_spec',
                'capacity',
                'pieces_count',
            ]);
        });
    }
};
