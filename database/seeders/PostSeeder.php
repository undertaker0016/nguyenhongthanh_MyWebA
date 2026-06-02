<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $title = fake()->unique()->sentence(6);

            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'image' => 'post-' . $i . '.png',
                'status' => fake()->numberBetween(0, 1),
                'user_id' => rand(1, 3),
                'content' => fake()->paragraph(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
