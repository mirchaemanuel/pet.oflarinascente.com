<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed pet funeral services for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating services...');

        // Create services with real images
        Service::factory()->withImage('dog1.webp')->create();
        Service::factory()->withImage('cat1.webp')->create();

        // Create additional services without images
        Service::factory()->count(3)->create();

        $this->command->line('  ✓ Created 5 services (2 with images)');
    }
}
