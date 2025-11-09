<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PetSpecies;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $species = fake()->randomElement(PetSpecies::cases());
        $birthDate = fake()->dateTimeBetween('-15 years', '-1 year');
        $deathDate = fake()->dateTimeBetween($birthDate, 'now');
        $ageYears = $deathDate->diff($birthDate)->y;
        $ageMonths = $deathDate->diff($birthDate)->m;

        $petNames = [
            PetSpecies::Dog->value => ['Max', 'Luna', 'Charlie', 'Bella', 'Rocky', 'Molly', 'Buddy', 'Daisy'],
            PetSpecies::Cat->value => ['Micio', 'Luna', 'Felix', 'Whiskers', 'Muffin', 'Shadow', 'Tigre'],
            PetSpecies::Rabbit->value => ['Floppy', 'Bunny', 'Carrot', 'Cotton', 'Snowball'],
            PetSpecies::Bird->value => ['Tweety', 'Coco', 'Kiwi', 'Sunny', 'Pico'],
            PetSpecies::Other->value => ['Lucky', 'Buddy', 'Pepe', 'Nemo'],
        ];

        $name = fake()->randomElement($petNames[$species->value] ?? ['Lucky', 'Buddy', 'Pepe']);

        return [
            'name' => $name,
            'species' => $species,
            'breed' => fake()->optional(0.7)->words(2, true),
            'birth_date' => $birthDate,
            'death_date' => $deathDate,
            'age_years' => $ageYears,
            'age_months' => $ageMonths,
            'dedication' => fake()->optional(0.8)->sentence(),
            'story' => fake()->optional(0.6)->paragraphs(3, true),
            'owner_name' => fake()->optional(0.5)->name(),
            'owner_email' => fake()->optional(0.4)->safeEmail(),
            'owner_phone' => fake()->optional(0.3)->phoneNumber(),
            'is_published' => fake()->boolean(80),
            'published_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'hearts_count' => fake()->numberBetween(0, 150),
            'candles_count' => fake()->numberBetween(0, 50),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
