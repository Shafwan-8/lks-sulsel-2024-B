<?php

namespace Database\Seeders;

use App\Models\categories;
use App\Models\destination;
use App\Models\event;
use App\Models\gallery;
use App\Models\post;
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
        // User::factory(10)->create();

        // User::create([
        //     'name' => 'WIWIN',
        //     'username' => 'wawin',
        //     'email' => 'wawin@gmail.com',
        //     'password' => bcrypt('wawin'),
        // ]);

        // event::factory(10)->create();
        // destination::factory(10)->create();
        // gallery::factory(10)->create();
        for ($i = 0; $i < 5; $i++)
        {
            categories::create([
                'name' => fake()->name()
            ]);
        }
        post::factory(10)->create();

    }
}
