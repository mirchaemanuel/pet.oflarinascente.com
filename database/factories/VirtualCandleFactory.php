<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pet;
use App\Models\VirtualCandle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VirtualCandle>
 */
class VirtualCandleFactory extends Factory
{
    protected $model = VirtualCandle::class;

    public function definition(): array
    {
        return [
            'pet_id' => Pet::factory(),
            'lit_by_name' => fake()->boolean(70) ? fake()->firstName() : null,
            'message' => fake()->boolean(50) ? fake()->sentence() : null,
            'ip_address' => fake()->ipv4(),
            'expires_at' => fake()->boolean(80) ? fake()->dateTimeBetween('now', '+7 days') : null,
        ];
    }
}
