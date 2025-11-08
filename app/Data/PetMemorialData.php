<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\PetSpecies;
use DateTimeInterface;

readonly class PetMemorialData
{
    public function __construct(
        public string $name,
        public PetSpecies $species,
        public ?string $breed = null,
        public ?DateTimeInterface $birthDate = null,
        public ?DateTimeInterface $deathDate = null,
        public ?int $ageYears = null,
        public ?int $ageMonths = null,
        public ?string $dedication = null,
        public ?string $story = null,
        public ?string $ownerName = null,
        public ?string $ownerEmail = null,
        public ?string $ownerPhone = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            species: $data['species'] instanceof PetSpecies ? $data['species'] : PetSpecies::from($data['species']),
            breed: $data['breed'] ?? null,
            birthDate: $data['birth_date'] ?? null,
            deathDate: $data['death_date'] ?? null,
            ageYears: $data['age_years'] ?? null,
            ageMonths: $data['age_months'] ?? null,
            dedication: $data['dedication'] ?? null,
            story: $data['story'] ?? null,
            ownerName: $data['owner_name'] ?? null,
            ownerEmail: $data['owner_email'] ?? null,
            ownerPhone: $data['owner_phone'] ?? null,
        );
    }
}
