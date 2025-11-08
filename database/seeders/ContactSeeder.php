<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Seed contact form submissions for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating contacts...');

        Contact::factory()->count(15)->create();

        $this->command->line('  ✓ Created 15 contact submissions');
    }
}
