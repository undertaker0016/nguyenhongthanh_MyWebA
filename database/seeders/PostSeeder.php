<?php

namespace Database\Seeders;

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
        for ($i = 1; $i <= 50; $i++) {

            $title = fake()->sentence(rand(3, 6));

            DB::table('posts')->insert([
                'title'      => $title,
                'slug'       => Str::slug($title) . '-' . $i,
                'content'    => fake()->paragraphs(rand(3, 8), true),
                'image'      => 'post-' . rand(1, 10) . '.jpg',
                'status'     => rand(0, 1),
                'user_id'    => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}