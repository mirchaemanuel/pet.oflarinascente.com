<?php

declare(strict_types=1);

namespace App\Actions\Pets;

use App\Data\PetMemorialData;
use App\Models\Pet;
use Illuminate\Support\Str;

class CreatePetMemorialAction
{
    public function execute(PetMemorialData $data): Pet
    {
        return Pet::create([
            'uuid' => Str::uuid(),
            'name' => $data->name,
            'species' => $data->species,
            'breed' => $data->breed,
            'birth_date' => $data->birthDate,
            'death_date' => $data->deathDate,
            'age_years' => $data->ageYears,
            'age_months' => $data->ageMonths,
            'dedication' => $data->dedication,
            'story' => $data->story,
            'owner_name' => $data->ownerName,
            'owner_email' => $data->ownerEmail,
            'owner_phone' => $data->ownerPhone,
            'is_published' => false, // Always starts unpublished for moderation
            'published_at' => null,
        ]);
    }
}
