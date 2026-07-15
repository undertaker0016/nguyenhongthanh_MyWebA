<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'fullname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0900000001',
            'role' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User
        DB::table('users')->insert([
            'fullname' => 'User',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0900000002',
            'role' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo thêm dữ liệu ngẫu nhiên
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'fullname' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('123456'),
                'phone' => fake()->numerify('09########'),
                'role' => rand(1, 2),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
