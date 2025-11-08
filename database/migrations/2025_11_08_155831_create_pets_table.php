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
        Schema::create('pets', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();

            // Basic Information
            $table->string('name');
            $table->string('species'); // dog, cat, rabbit, bird, etc.
            $table->string('breed')->nullable();

            // Dates
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->unsignedSmallInteger('age_years')->nullable();
            $table->unsignedTinyInteger('age_months')->nullable();

            // Memorial Content
            $table->text('dedication')->nullable(); // Short dedication
            $table->longText('story')->nullable(); // Longer story/biography

            // Owner Information (optional)
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('owner_phone')->nullable();

            // Publishing & Moderation
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            // Counter Caches (for performance)
            $table->unsignedInteger('hearts_count')->default(0);
            $table->unsignedInteger('candles_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('is_published');
            $table->index('species');
            $table->index(['is_published', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
