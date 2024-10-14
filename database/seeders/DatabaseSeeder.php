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

        // User::factory()->create([
        //     'first_name' => 'Test User',
        //     'last_name' => '123',
        //     'email' => 'test@example.com',
        //     'password' => 'test123'
        // ]);
        User::factory()->create([
            'first_name' => 'jonathan',
            'last_name' => 'moralde',
            'email' => 'jona@test.com',
            'password' => '123456789'
        ]);
    }
}
