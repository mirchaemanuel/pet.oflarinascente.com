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
        Schema::create('pet_photos', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();

            $table->string('path'); // Storage path
            $table->string('disk')->default('public');
            $table->boolean('is_primary')->default(false);
            $table->unsignedSmallInteger('order')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['pet_id', 'is_primary']);
            $table->index(['pet_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_photos');
    }
};
