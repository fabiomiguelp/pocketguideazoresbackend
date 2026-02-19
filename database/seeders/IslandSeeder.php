<?php

namespace Database\Seeders;

use App\Models\Island;
use Illuminate\Database\Seeder;

class IslandSeeder extends Seeder
{
    public function run(): void
    {
        $islands = [
            [
                'name' => 'São Miguel',
                'slug' => 'sao-miguel',
                'cities' => [
                    'Ponta Delgada',
                    'Ribeira Grande',
                    'Lagoa',
                    'Vila Franca do Campo',
                    'Nordeste',
                    'Povoação',
                    'Furnas',
                ],
            ],
            [
                'name' => 'Santa Maria',
                'slug' => 'santa-maria',
                'cities' => [
                    'Vila do Porto',
                    'Santo Espírito',
                    'Almagreira',
                    'São Pedro',
                    'Santa Bárbara',
                ],
            ],
            [
                'name' => 'Terceira',
                'slug' => 'terceira',
                'cities' => [
                    'Angra do Heroísmo',
                    'Praia da Vitória',
                    'Biscoitos',
                    'São Sebastião',
                    'Altares',
                ],
            ],
            [
                'name' => 'Faial',
                'slug' => 'faial',
                'cities' => [
                    'Horta',
                    'Castelo Branco',
                    'Flamengos',
                    'Feteira',
                    'Ribeirinha',
                ],
            ],
            [
                'name' => 'Pico',
                'slug' => 'pico',
                'cities' => [
                    'Madalena',
                    'Lajes do Pico',
                    'São Roque do Pico',
                    'Prainha',
                    'Santo Amaro',
                ],
            ],
            [
                'name' => 'São Jorge',
                'slug' => 'sao-jorge',
                'cities' => [
                    'Velas',
                    'Calheta',
                    'Topo',
                    'Urzelina',
                    'Norte Grande',
                ],
            ],
            [
                'name' => 'Graciosa',
                'slug' => 'graciosa',
                'cities' => [
                    'Santa Cruz da Graciosa',
                    'Praia',
                    'Guadalupe',
                    'Luz',
                ],
            ],
            [
                'name' => 'Flores',
                'slug' => 'flores',
                'cities' => [
                    'Santa Cruz das Flores',
                    'Lajes das Flores',
                    'Fajã Grande',
                    'Fazenda',
                ],
            ],
            [
                'name' => 'Corvo',
                'slug' => 'corvo',
                'cities' => [
                    'Vila do Corvo',
                ],
            ],
        ];

        foreach ($islands as $islandData) {
            $cities = $islandData['cities'];
            unset($islandData['cities']);

            $island = Island::create($islandData);

            foreach ($cities as $cityName) {
                $island->cities()->create(['name' => $cityName]);
            }
        }
    }
}
