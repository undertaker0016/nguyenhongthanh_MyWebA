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
        // User::factory(10)->create();

        $this->call([
            //các seeder kh có khóa ngoại
            CategorySeeder::class,
            BrandSeeder::class,
            UserSeeder::class,
            //các seeder có khóa ngoại
            ProductSeeder::class,
            PostSeeder::class,
        ]);
    }
}
