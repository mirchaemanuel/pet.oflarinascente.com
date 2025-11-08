<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use RuntimeException;
use Storage;

/**
 * @extends Factory<PetPhoto>
 */
class PetPhotoFactory extends Factory
{
    protected $model = PetPhoto::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $uuid = Str::uuid();

        return [
            'pet_id' => Pet::factory(),
            'path' => 'pets/'.$uuid.'/photo-'.fake()->numberBetween(1, 5).'.jpg',
            'disk' => 'public',
            'is_primary' => false,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * Indicate that this photo is the primary photo for the pet.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_primary' => true,
            'order' => 0,
        ]);
    }

    /**
     * Set a specific order for the photo.
     */
    public function withOrder(int $order): static
    {
        return $this->state(fn (array $attributes): array => [
            'order' => $order,
        ]);
    }

    /**
     * Copy an actual image file from local_images to storage.
     */
    public function withImage(string $sourceImageName): static
    {
        return $this->state(function (array $attributes) use ($sourceImageName): array {
            $sourcePath = database_path('seeders/local_images/'.$sourceImageName);

            if (! file_exists($sourcePath)) {
                throw new RuntimeException("Source image not found: {$sourcePath}");
            }

            // Generate unique path for this photo
            $uuid = Str::uuid();
            $extension = pathinfo($sourceImageName, PATHINFO_EXTENSION);
            $filename = 'photo-'.fake()->numberBetween(1, 999).'.'.$extension;
            $destinationPath = 'pets/'.$uuid.'/'.$filename;

            // Ensure storage directory exists
            $disk = Storage::disk('public');
            $disk->makeDirectory(dirname($destinationPath));

            // Copy file to storage
            $fileContents = file_get_contents($sourcePath);
            $disk->put($destinationPath, $fileContents);

            return [
                'path' => $destinationPath,
                'disk' => 'public',
            ];
        });
    }
}
