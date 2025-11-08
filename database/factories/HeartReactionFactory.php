<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HeartReaction;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeartReaction>
 */
class HeartReactionFactory extends Factory
{
    protected $model = HeartReaction::class;

    public function definition(): array
    {
        return [
            'pet_id' => Pet::factory(),
            'ip_address' => fake()->unique()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
