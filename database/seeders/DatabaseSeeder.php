<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * The behavior changes based on the environment:
     * - Production: BLOCKED - No seeding allowed in production
     * - Non-Production: Runs all development seeders for testing/development
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('========================================');
        $this->command->info('  Pet Memorial Services - Database Seeder');
        $this->command->info('========================================');
        $this->command->newLine();

        if ($this->isProduction()) {
            $this->blockProductionSeeding();

            return;
        }

        $this->seedDevelopment();

        $this->command->newLine();
        $this->command->info('Database seeding completed successfully!');
        $this->command->newLine();
    }

    /**
     * Block seeding in production environment.
     */
    protected function blockProductionSeeding(): void
    {
        $this->command->error('⛔ SEEDING BLOCKED IN PRODUCTION');
        $this->command->newLine();
        $this->command->line('  Seeders are disabled in production environment.');
        $this->command->newLine();
    }

    /**
     * Seed development/testing environment with sample data.
     */
    protected function seedDevelopment(): void
    {
        $this->command->info('Running in DEVELOPMENT mode');
        $this->command->line('Sample data will be created for testing.');
        $this->command->newLine();

        // Seed in the correct order (respecting dependencies)
        $this->call([
            SettingSeeder::class,   // Settings (independent)
            UserSeeder::class,      // Must run first (required by PostSeeder)
            ServiceSeeder::class,   // Must run before BookingSeeder
            PostSeeder::class,      // Requires UserSeeder
            PetSeeder::class,       // Independent
            ContactSeeder::class,   // Independent
            BookingSeeder::class,   // Requires ServiceSeeder
        ]);

        $this->command->newLine();
        $this->command->info('========================================');
        $this->command->info('  Admin Panel Credentials');
        $this->command->info('========================================');
        $this->command->line('  Email:    admin@pet.test');
        $this->command->line('  Password: password');
        $this->command->info('========================================');
    }

    /**
     * Check if running in production environment.
     */
    protected function isProduction(): bool
    {
        return app()->environment('production');
    }
}
