<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IslandSeeder::class,
            TripCategorySeeder::class,
            BudgetLevelSeeder::class,
            CityGemSeeder::class,
            PartnerSeeder::class,
        ]);

        User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@mytriptaylor.com',
            'role'  => 'admin',
        ]);

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'user@mytriptaylor.com',
            'role'  => 'user',
        ]);

        User::factory(10)->create(['role' => 'user']);
    }
}
