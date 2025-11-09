<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Seed blog posts for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating blog posts...');

        // Get the admin user (should exist from UserSeeder)
        $admin = User::query()->where('email', 'admin@pet.test')->first();

        if (! $admin) {
            $this->command->warn('  ⚠ Admin user not found. Run UserSeeder first.');

            return;
        }

        // Create posts with real images
        Post::factory()->withImage('dog1.webp')->create([
            'author_id' => $admin->id,
        ]);
        Post::factory()->withImage('cat1.webp')->create([
            'author_id' => $admin->id,
        ]);

        // Create additional posts without images
        Post::factory()->count(10)->create([
            'author_id' => $admin->id,
        ]);

        $this->command->line('  ✓ Created 12 blog posts (2 with images)');
    }
}
