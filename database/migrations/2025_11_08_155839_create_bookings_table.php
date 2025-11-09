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
        Schema::create('bookings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();

            // Pet Information
            $table->string('pet_name');
            $table->string('pet_species')->nullable();
            $table->string('pet_breed')->nullable();
            $table->decimal('pet_weight_kg', 5, 2)->nullable(); // Important for pricing

            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address')->nullable();

            // Booking Details
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->text('message')->nullable();
            $table->text('special_requests')->nullable();

            // Status & Management
            $table->string('status')->default('pending'); // pending, confirmed, in_progress, completed, cancelled
            $table->text('notes')->nullable(); // Internal admin notes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('preferred_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
