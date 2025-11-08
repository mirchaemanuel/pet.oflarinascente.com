<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PetSpecies;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(BookingStatus::cases());
        $preferredDate = fake()->dateTimeBetween('+1 day', '+90 days');

        $italianPhonePrefixes = ['340', '360', '370', '380', '335', '320'];
        $phone = fake()->randomElement($italianPhonePrefixes).' '.fake()->numerify('## ## ##');

        $petNames = ['Max', 'Luna', 'Charlie', 'Bella', 'Rocky', 'Molly', 'Buddy', 'Daisy', 'Micio', 'Felix'];
        $customerNames = fake()->name();

        return [
            'service_id' => Service::factory(),
            'pet_name' => fake()->randomElement($petNames),
            'pet_species' => fake()->randomElement(PetSpecies::cases()),
            'pet_breed' => fake()->optional(0.6)->words(2, true),
            'pet_weight_kg' => fake()->randomFloat(2, 1, 50),
            'customer_name' => $customerNames,
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => $phone,
            'customer_address' => fake()->address(),
            'preferred_date' => $preferredDate,
            'preferred_time' => fake()->numberBetween(9, 17).':'.fake()->randomElement(['00', '30']),
            'message' => fake()->optional(0.5)->sentence(),
            'special_requests' => fake()->optional(0.3)->sentence(),
            'status' => $status,
            'notes' => fake()->optional(0.2)->sentence(),
            'confirmed_at' => in_array($status, [BookingStatus::Confirmed, BookingStatus::InProgress, BookingStatus::Completed], true)
                ? fake()->dateTimeBetween('-30 days', 'now')
                : null,
            'completed_at' => $status === BookingStatus::Completed
                ? fake()->dateTimeBetween('-30 days', 'now')
                : null,
        ];
    }

    /**
     * Indicate that the booking is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BookingStatus::Pending,
            'confirmed_at' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BookingStatus::Confirmed,
            'confirmed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the booking is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BookingStatus::InProgress,
            'confirmed_at' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BookingStatus::Completed,
            'confirmed_at' => fake()->dateTimeBetween('-60 days', '-30 days'),
            'completed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BookingStatus::Cancelled,
            'confirmed_at' => null,
            'completed_at' => null,
        ]);
    }
}
