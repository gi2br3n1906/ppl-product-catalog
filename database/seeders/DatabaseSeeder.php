<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a test user only if it does not already exist (avoid duplicate seeding)
        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                // If you want a specific password for the test user in dev, set it here
                'password' => bcrypt('test1234'),
            ]
        );

        // Seed demo products
        $this->call(ProductSeeder::class);
    }
}
