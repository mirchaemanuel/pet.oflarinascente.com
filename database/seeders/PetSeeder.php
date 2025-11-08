<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HeartReaction;
use App\Models\Pet;
use App\Models\PetPhoto;
use App\Models\VirtualCandle;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Seed pet memorials with photos, hearts, and candles for development/testing.
     */
    public function run(): void
    {
        $this->command->info('Creating pet memorials...');

        Pet::factory()
            ->count(30)
            ->create()
            ->each(function (Pet $pet): void {
                $photoCount = fake()->numberBetween(1, 5);
                $useRealImage = true; // Use real image for primary photo

                // Add photos (1-5 per pet)
                for ($i = 0; $i < $photoCount; $i++) {
                    $isPrimary = $i === 0;

                    if ($isPrimary) {
                        // Use real image for primary photo based on species
                        $imageName = match ($pet->species->value) {
                            'dog' => 'dog1.webp',
                            'cat' => 'cat1.webp',
                            default => fake()->randomElement(['dog1.webp', 'cat1.webp']),
                        };

                        PetPhoto::factory()
                            ->withImage($imageName)
                            ->primary()
                            ->create([
                                'pet_id' => $pet->id,
                            ]);
                    } else {
                        // Regular photo without real image
                        PetPhoto::factory()->create([
                            'pet_id' => $pet->id,
                            'is_primary' => $isPrimary,
                            'order' => $i,
                        ]);
                    }
                }

                // Add hearts (0-20 per pet)
                HeartReaction::factory()->count(fake()->numberBetween(0, 20))->create([
                    'pet_id' => $pet->id,
                ]);

                // Add candles (0-10 per pet)
                VirtualCandle::factory()->count(fake()->numberBetween(0, 10))->create([
                    'pet_id' => $pet->id,
                ]);
            });

        $this->command->line('  ✓ Created 30 pet memorials with photos, hearts, and candles');
    }
}
