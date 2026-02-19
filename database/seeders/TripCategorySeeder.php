<?php

namespace Database\Seeders;

use App\Models\TripCategory;
use Illuminate\Database\Seeder;

class TripCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Popular',     'slug' => 'popular',     'icon' => 'star'],
            ['name' => 'Aventura',    'slug' => 'aventura',    'icon' => 'hiking'],
            ['name' => 'Natureza',    'slug' => 'natureza',    'icon' => 'nature'],
            ['name' => 'Gastronomia', 'slug' => 'gastronomia', 'icon' => 'restaurant'],
            ['name' => 'Histórico',   'slug' => 'historico',   'icon' => 'museum'],
            ['name' => 'Praia',       'slug' => 'praia',       'icon' => 'beach'],
            ['name' => 'Compras',     'slug' => 'compras',     'icon' => 'shopping'],
            ['name' => 'Romântico',   'slug' => 'romantico',   'icon' => 'favorite'],
        ];

        foreach ($categories as $category) {
            TripCategory::create($category);
        }
    }
}
