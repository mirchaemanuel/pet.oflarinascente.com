<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed admin users for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating admin user...');

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@pet.test',
            'password' => bcrypt('password'),
        ]);

        $this->command->line('  ✓ Admin user created (admin@pet.test / password)');
    }
}
