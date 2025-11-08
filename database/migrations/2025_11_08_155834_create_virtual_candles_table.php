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
        Schema::create('virtual_candles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();

            $table->string('lit_by_name')->nullable(); // Optional name of person lighting candle
            $table->text('message')->nullable(); // Optional message
            $table->string('ip_address', 45);

            $table->timestamp('expires_at')->nullable(); // Candle "burns out" after X days

            $table->timestamps();

            // Indexes
            $table->index('pet_id');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_candles');
    }
};
