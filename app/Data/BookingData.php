<?php

declare(strict_types=1);

namespace App\Data;

use DateTimeInterface;

readonly class BookingData
{
    public function __construct(
        public ?int $serviceId,
        public string $petName,
        public string $customerName,
        public string $customerEmail,
        public string $customerPhone,
        public ?string $petSpecies = null,
        public ?string $petBreed = null,
        public ?float $petWeightKg = null,
        public ?string $customerAddress = null,
        public ?DateTimeInterface $preferredDate = null,
        public ?string $preferredTime = null,
        public ?string $message = null,
        public ?string $specialRequests = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function from(array $data): self
    {
        return new self(
            serviceId: $data['service_id'] ?? null,
            petName: $data['pet_name'],
            customerName: $data['customer_name'],
            customerEmail: $data['customer_email'],
            customerPhone: $data['customer_phone'],
            petSpecies: $data['pet_species'] ?? null,
            petBreed: $data['pet_breed'] ?? null,
            petWeightKg: $data['pet_weight_kg'] ?? null,
            customerAddress: $data['customer_address'] ?? null,
            preferredDate: $data['preferred_date'] ?? null,
            preferredTime: $data['preferred_time'] ?? null,
            message: $data['message'] ?? null,
            specialRequests: $data['special_requests'] ?? null,
        );
    }
}
