<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return;
        }

        $newsArticles = [
            [
                'title' => 'Nuevas técnicas de construcción sostenible',
                'slug' => 'nuevas-tecnicas-construccion-sostenible',
                'excerpt' => 'Descubre las últimas técnicas para construir de manera sostenible y eficiente.',
                'content' => '<p>Las técnicas de construcción sostenible están revolucionando la industria...</p>',
                'author_id' => $admin->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Guía completa para elegir los mejores materiales',
                'slug' => 'guia-elegir-mejores-materiales',
                'excerpt' => 'Aprende cómo seleccionar los materiales correctos para tu proyecto.',
                'content' => '<p>La elección de materiales es fundamental para el éxito de cualquier proyecto...</p>',
                'author_id' => $admin->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Novedades en aceros de construcción',
                'slug' => 'novedades-aceros-construccion',
                'excerpt' => 'Conoce los últimos avances en aceros para proyectos de construcción.',
                'content' => '<p>La industria del acero continúa innovando con nuevas aleaciones...</p>',
                'author_id' => $admin->id,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($newsArticles as $article) {
            News::firstOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}
