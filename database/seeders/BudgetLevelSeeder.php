<?php

namespace Database\Seeders;

use App\Models\BudgetLevel;
use Illuminate\Database\Seeder;

class BudgetLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Mochileiro', 'slug' => 'mochileiro', 'min_budget' => 10, 'max_budget' => 20],
            ['name' => 'Económico',  'slug' => 'economico',  'min_budget' => 20, 'max_budget' => 40],
            ['name' => 'Conforto',   'slug' => 'conforto',   'min_budget' => 40, 'max_budget' => 60],
            ['name' => 'Luxo',       'slug' => 'luxo',       'min_budget' => 60, 'max_budget' => null],
        ];

        foreach ($levels as $level) {
            BudgetLevel::create($level);
        }
    }
}
