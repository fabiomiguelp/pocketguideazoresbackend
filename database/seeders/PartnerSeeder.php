<?php

namespace Database\Seeders;

use App\Models\BudgetLevel;
use App\Models\Island;
use App\Models\Partner;
use App\Models\TripCategory;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            // São Miguel
            [
                'name'     => 'Azores Adventure Tours',
                'description' => 'Canyoning e rappel nas cascatas de São Miguel com guias certificados.',
                'island'   => 'São Miguel',
                'budget'   => 'conforto',
                'category' => 'aventura',
                'price'    => 55.00,
                'contact'  => '+351 296 123 456',
                'link'     => 'https://example.com/azores-adventure',
            ],
            [
                'name'     => 'Furnas Gourmet Experience',
                'description' => 'Tour gastronómico pelas Furnas com degustação de cozido vulcânico e chás.',
                'island'   => 'São Miguel',
                'budget'   => 'conforto',
                'category' => 'gastronomia',
                'price'    => 45.00,
                'contact'  => '+351 296 234 567',
                'link'     => null,
            ],
            [
                'name'     => 'Whale Watch Azores',
                'description' => 'Observação de baleias e golfinhos com biólogo marinho a bordo.',
                'island'   => 'São Miguel',
                'budget'   => 'economico',
                'category' => 'natureza',
                'price'    => 35.00,
                'contact'  => '+351 296 345 678',
                'link'     => 'https://example.com/whale-watch',
            ],
            [
                'name'     => 'São Miguel Luxury Spa',
                'description' => 'Circuito termal de luxo com tratamentos de águas vulcânicas e massagens.',
                'island'   => 'São Miguel',
                'budget'   => 'luxo',
                'category' => 'romantico',
                'price'    => 120.00,
                'contact'  => '+351 296 456 789',
                'link'     => 'https://example.com/luxury-spa',
            ],
            // Terceira
            [
                'name'     => 'Terceira Diving Center',
                'description' => 'Mergulho nos recifes e grutas submarinas de Angra do Heroísmo.',
                'island'   => 'Terceira',
                'budget'   => 'conforto',
                'category' => 'aventura',
                'price'    => 60.00,
                'contact'  => '+351 295 123 456',
                'link'     => null,
            ],
            [
                'name'     => 'Angra Walking Tours',
                'description' => 'Tour guiado pelo centro histórico UNESCO de Angra do Heroísmo.',
                'island'   => 'Terceira',
                'budget'   => 'economico',
                'category' => 'historico',
                'price'    => 20.00,
                'contact'  => '+351 295 234 567',
                'link'     => 'https://example.com/angra-tours',
            ],
            // Faial
            [
                'name'     => 'Faial Sailing Experience',
                'description' => 'Passeio de veleiro ao redor do Faial com paragem para snorkeling.',
                'island'   => 'Faial',
                'budget'   => 'luxo',
                'category' => 'aventura',
                'price'    => 95.00,
                'contact'  => '+351 292 123 456',
                'link'     => null,
            ],
            // Pico
            [
                'name'     => 'Pico Mountain Guides',
                'description' => 'Subida guiada ao Monte Pico (2351m), o ponto mais alto de Portugal.',
                'island'   => 'Pico',
                'budget'   => 'economico',
                'category' => 'aventura',
                'price'    => 30.00,
                'contact'  => '+351 292 234 567',
                'link'     => 'https://example.com/pico-mountain',
            ],
            [
                'name'     => 'Pico Wine Tasting',
                'description' => 'Degustação de vinhos Verdelho nas vinhas UNESCO da ilha do Pico.',
                'island'   => 'Pico',
                'budget'   => 'conforto',
                'category' => 'gastronomia',
                'price'    => 40.00,
                'contact'  => '+351 292 345 678',
                'link'     => null,
            ],
            // Flores
            [
                'name'     => 'Flores Boat Tours',
                'description' => 'Passeio de barco pela costa oeste com cascatas e grutas marinhas.',
                'island'   => 'Flores',
                'budget'   => 'conforto',
                'category' => 'natureza',
                'price'    => 50.00,
                'contact'  => '+351 292 456 789',
                'link'     => 'https://example.com/flores-boat',
            ],
        ];

        foreach ($partners as $data) {
            $island   = Island::where('slug', str_replace(' ', '-', strtolower($data['island'])))->orWhere('name', $data['island'])->first();
            $budget   = BudgetLevel::where('slug', $data['budget'])->first();
            $category = TripCategory::where('slug', $data['category'])->first();

            if (!$island || !$budget || !$category) {
                continue;
            }

            Partner::create([
                'name'             => $data['name'],
                'description'      => $data['description'],
                'island_id'        => $island->id,
                'budget_level_id'  => $budget->id,
                'trip_category_id' => $category->id,
                'price'            => $data['price'],
                'contact'          => $data['contact'],
                'link'             => $data['link'],
            ]);
        }
    }
}
