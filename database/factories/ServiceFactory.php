<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use RuntimeException;
use Storage;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Cremazione Singola con Restituzione Ceneri',
            'Cremazione Collettiva',
            'Cremazione con Urna Personalizzata',
            'Sepoltura in Giardino del Riposo',
            'Servizio di Ritiro a Domicilio',
            'Bara Biodegradabile per Sepoltura',
            'Servizio Completo con Cerimonia',
            'Conservazione Ceneri in Urna Artistica',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'detailed_description' => fake()->paragraphs(3, true),
            'price_from' => fake()->randomFloat(2, 50, 500),
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
            'features' => [
                ['feature' => 'Servizio professionale'],
                ['feature' => 'Massimo rispetto'],
                ['feature' => 'Disponibile 24/7'],
            ],
            'meta_description' => fake()->sentence(),
            'meta_keywords' => 'pet, animali, servizio funebre',
        ];
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

            // Generate unique path for this service
            $extension = pathinfo($sourceImageName, PATHINFO_EXTENSION);
            $filename = 'service-'.Str::slug($attributes['name']).'.'.$extension;
            $destinationPath = 'services/'.$filename;

            // Ensure storage directory exists
            $disk = Storage::disk('public');
            $disk->makeDirectory('services');

            // Copy file to storage
            $fileContents = file_get_contents($sourcePath);
            $disk->put($destinationPath, $fileContents);

            return [
                'image_path' => $destinationPath,
            ];
        });
    }
}
