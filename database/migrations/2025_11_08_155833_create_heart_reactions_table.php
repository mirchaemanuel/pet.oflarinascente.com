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
        Schema::create('heart_reactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();

            $table->string('ip_address', 45); // IPv4 or IPv6
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // Prevent duplicate hearts from same IP for same pet
            $table->unique(['pet_id', 'ip_address']);
            $table->index('pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heart_reactions');
    }
};
