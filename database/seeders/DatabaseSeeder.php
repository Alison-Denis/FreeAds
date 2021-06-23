<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Annonce, User};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()
        ->has(Annonce::factory()->count(4))
        ->count(10)
        ->create();
    }
}
