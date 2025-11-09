<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use RuntimeException;
use Storage;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image_path' => null,
            'reading_time_minutes' => fake()->numberBetween(2, 15),
            'is_published' => fake()->boolean(80),
            'published_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'meta_description' => fake()->sentence(),
            'meta_keywords' => fake()->words(5, true),
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

            // Generate unique path for this post
            $extension = pathinfo($sourceImageName, PATHINFO_EXTENSION);
            $filename = 'post-'.Str::slug($attributes['title']).'.'.$extension;
            $destinationPath = 'posts/'.$filename;

            // Ensure storage directory exists
            $disk = Storage::disk('public');
            $disk->makeDirectory('posts');

            // Copy file to storage
            $fileContents = file_get_contents($sourcePath);
            $disk->put($destinationPath, $fileContents);

            return [
                'featured_image_path' => $destinationPath,
            ];
        });
    }
}
