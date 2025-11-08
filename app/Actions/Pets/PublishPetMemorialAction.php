<?php

declare(strict_types=1);

namespace App\Actions\Pets;

use App\Models\Pet;

class PublishPetMemorialAction
{
    public function execute(Pet $pet): Pet
    {
        $pet->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return $pet->fresh();
    }
}
