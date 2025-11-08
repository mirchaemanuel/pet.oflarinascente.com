<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['text', 'textarea', 'number', 'boolean', 'email', 'tel', 'url'];
        $groups = ['general', 'contact', 'business', 'social', 'seo', 'advanced'];

        return [
            'key' => fake()->unique()->slug(2),
            'value' => fake()->sentence(),
            'group' => fake()->randomElement($groups),
            'type' => fake()->randomElement($types),
            'description' => fake()->optional()->sentence(),
            'metadata' => null,
        ];
    }

    /**
     * General settings group.
     */
    public function general(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'general',
        ]);
    }

    /**
     * Contact settings group.
     */
    public function contact(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'contact',
        ]);
    }

    /**
     * Business settings group.
     */
    public function business(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'business',
        ]);
    }

    /**
     * Social settings group.
     */
    public function social(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'social',
        ]);
    }

    /**
     * SEO settings group.
     */
    public function seo(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'seo',
        ]);
    }

    /**
     * Advanced settings group.
     */
    public function advanced(): static
    {
        return $this->state(fn (array $attributes): array => [
            'group' => 'advanced',
        ]);
    }
}
