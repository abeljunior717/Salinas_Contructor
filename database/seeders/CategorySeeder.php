<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Aceros',
                'slug' => 'aceros',
                'description' => 'Barras, perfiles y estructuras de acero',
                'position' => 1,
            ],
            [
                'name' => 'Cementos',
                'slug' => 'cementos',
                'description' => 'Cementos y mezclas para construcción',
                'position' => 2,
            ],
            [
                'name' => 'Carpintería',
                'slug' => 'carpinteria',
                'description' => 'Maderas, puertas y marcos',
                'position' => 3,
            ],
            [
                'name' => 'Electricidad',
                'slug' => 'electricidad',
                'description' => 'Cables, conductores y accesorios eléctricos',
                'position' => 4,
            ],
            [
                'name' => 'Pintura',
                'slug' => 'pintura',
                'description' => 'Pinturas y recubrimientos',
                'position' => 5,
            ],
            [
                'name' => 'Plomería',
                'slug' => 'plomeria',
                'description' => 'Tuberías, accesorios y sistemas de agua',
                'position' => 6,
            ],
            [
                'name' => 'Herramientas',
                'slug' => 'herramientas',
                'description' => 'Herramientas manuales y eléctricas',
                'position' => 7,
            ],
            [
                'name' => 'Vidrios',
                'slug' => 'vidrios',
                'description' => 'Vidrios planos y templados',
                'position' => 8,
            ],
            [
                'name' => 'Suelos Granulares',
                'slug' => 'suelos-granulares',
                'description' => 'Arenas, gravas y materiales de relleno',
                'position' => 9,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
