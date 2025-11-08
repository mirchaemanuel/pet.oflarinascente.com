<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Seed service bookings for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating bookings...');

        // Get all services (should exist from ServiceSeeder)
        $services = Service::all();

        if ($services->isEmpty()) {
            $this->command->warn('  ⚠ No services found. Run ServiceSeeder first.');

            return;
        }

        Booking::factory()->count(20)->create([
            'service_id' => fn () => $services->random()->id,
        ]);

        $this->command->line('  ✓ Created 20 service bookings');
    }
}
