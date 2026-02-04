<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Create a known admin user (email: admin@example.com / password: password)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Create a known member user (email: member@example.com / password: password)
        User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'role' => 'member',
            'password' => bcrypt('password'),
        ]);

        // create some additional random member users
        User::factory(3)->create();

        // Seed polls, options, and votes
        $this->call(PollSeeder::class);
    }
}
