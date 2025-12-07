<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productsData = [
            ['categorySlug' => 'cementos', 'name' => 'Cemento Portland 50kg', 'slug' => 'cemento-portland-50kg', 'description' => 'Cemento de alta calidad para construcción', 'price' => 120000, 'unit' => 'saco', 'stock_quantity' => 50, 'sku' => 'CEP-50', 'status' => 'disponible', 'image_url' => 'https://toolstoremexico.com.mx/img/p/2/0/4/1/5/20415-large_default.jpg'],
            ['categorySlug' => 'aceros', 'name' => 'Varilla Corrugada 1/2"', 'slug' => 'varilla-corrugada-1-2', 'description' => 'Varilla de acero corrugado para refuerzo', 'price' => 150000, 'unit' => 'pieza', 'stock_quantity' => 30, 'sku' => 'VAC-12', 'status' => 'disponible'],
            ['categorySlug' => 'vidrios', 'name' => 'Lámina Galvanizada R-101', 'slug' => 'lamina-galvanizada-r-101', 'description' => 'Lámina de acero galvanizado para techumbre', 'price' => 350000, 'unit' => 'pieza', 'stock_quantity' => 15, 'sku' => 'LAM-101', 'status' => 'disponible'],
            ['categorySlug' => 'vidrios', 'name' => 'Vidrio Templado 6mm', 'slug' => 'vidrio-templado-6mm', 'description' => 'Vidrio templado de seguridad', 'price' => 550000, 'unit' => 'm2', 'stock_quantity' => 0, 'sku' => 'VID-6mm', 'status' => 'agotado'],
            ['categorySlug' => 'carpinteria', 'name' => 'Tabla de Pino 2x4', 'slug' => 'tabla-pino-2x4', 'description' => 'Madera de pino tratado para construcción', 'price' => 25000, 'unit' => 'pieza', 'stock_quantity' => 100, 'sku' => 'TAP-2x4', 'status' => 'disponible'],
            ['categorySlug' => 'electricidad', 'name' => 'Cable Eléctrico #12 AWG', 'slug' => 'cable-electrico-12awg', 'description' => 'Cable de cobre para instalaciones', 'price' => 5000, 'unit' => 'metro', 'stock_quantity' => 500, 'sku' => 'CAB-12', 'status' => 'disponible'],
            ['categorySlug' => 'plomeria', 'name' => 'Tubería PVC 3/4"', 'slug' => 'tuberia-pvc-3-4', 'description' => 'Tubería de PVC para agua', 'price' => 8000, 'unit' => 'metro', 'stock_quantity' => 200, 'sku' => 'TUB-34', 'status' => 'disponible'],
            ['categorySlug' => 'herramientas', 'name' => 'Martillo Stanley 16oz', 'slug' => 'martillo-stanley-16oz', 'description' => 'Martillo de goma con mango', 'price' => 45000, 'unit' => 'pieza', 'stock_quantity' => 20, 'sku' => 'MAR-16', 'status' => 'disponible'],
            ['categorySlug' => 'suelos-granulares', 'name' => 'Arena Fina para Construcción', 'slug' => 'arena-fina', 'description' => 'Arena tamizada para mezclas', 'price' => 35000, 'unit' => 'm3', 'stock_quantity' => 100, 'sku' => 'ARE-1', 'status' => 'disponible'],
            ['categorySlug' => 'pintura', 'name' => 'Pintura Latex Blanca 5L', 'slug' => 'pintura-latex-blanca-5l', 'description' => 'Pintura latex de buena cobertura', 'price' => 55000, 'unit' => 'galón', 'stock_quantity' => 40, 'sku' => 'PIN-LTX', 'status' => 'disponible'],
        ];

        foreach ($productsData as $data) {
            $categorySlug = $data['categorySlug'];
            unset($data['categorySlug']);
            
            $category = Category::where('slug', $categorySlug)->first();
            
            if ($category) {
                Product::firstOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['category_id' => $category->id])
                );
            }
        }
    }
}
