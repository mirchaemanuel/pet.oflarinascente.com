<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Pets\CreatePetMemorialAction;
use App\Actions\Pets\PublishPetMemorialAction;
use App\Data\PetMemorialData;
use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PetMemorialService
{
    public function __construct(
        private readonly CreatePetMemorialAction $createAction,
        private readonly PublishPetMemorialAction $publishAction,
    ) {}

    /**
     * Create a new pet memorial with photos
     *
     * @param  array<UploadedFile>  $photos
     */
    public function createMemorial(PetMemorialData $data, array $photos = []): Pet
    {
        $pet = $this->createAction->execute($data);

        if ($photos !== []) {
            $this->attachPhotos($pet, $photos);
        }

        return $pet->fresh();
    }

    /**
     * Attach photos to a pet memorial
     *
     * @param  array<UploadedFile>  $photos
     */
    public function attachPhotos(Pet $pet, array $photos): void
    {
        foreach ($photos as $index => $photo) {
            $path = $photo->store('pets/'.$pet->uuid, 'public');

            PetPhoto::create([
                'pet_id' => $pet->id,
                'path' => $path,
                'disk' => 'public',
                'is_primary' => $index === 0, // First photo is primary
                'order' => $index,
            ]);
        }
    }

    /**
     * Publish a pet memorial (after moderation)
     */
    public function publishMemorial(Pet $pet): Pet
    {
        return $this->publishAction->execute($pet);
    }

    /**
     * Unpublish a pet memorial
     */
    public function unpublishMemorial(Pet $pet): Pet
    {
        $pet->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return $pet->fresh();
    }

    /**
     * Delete a pet memorial and its photos
     */
    public function deleteMemorial(Pet $pet): bool
    {
        // Delete all photos from storage
        foreach ($pet->photos as $photo) {
            Storage::disk($photo->disk)->delete($photo->path);
        }

        return $pet->delete();
    }
}
