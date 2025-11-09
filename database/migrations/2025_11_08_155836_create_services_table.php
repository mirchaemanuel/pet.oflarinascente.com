<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description'); // Short description
            $table->longText('detailed_description')->nullable(); // Full description with rich text

            // Pricing
            $table->decimal('price_from', 10, 2)->nullable(); // "Starting from" price
            $table->string('price_notes')->nullable(); // e.g., "Price varies by weight"

            // Settings
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->string('icon')->nullable(); // Icon class or path

            // Features as JSON array
            $table->json('features')->nullable(); // ["Feature 1", "Feature 2"]

            // Image
            $table->string('image_path')->nullable();

            // SEO
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
