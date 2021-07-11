<?php

namespace Database\Seeders;

use App\Models\SuperHeroes;
use Illuminate\Database\Seeder;

class SuperHeroesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         SuperHeroes::factory(50)->create();
    }
}
