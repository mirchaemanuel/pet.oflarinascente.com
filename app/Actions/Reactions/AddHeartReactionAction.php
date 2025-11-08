<?php

declare(strict_types=1);

namespace App\Actions\Reactions;

use App\Exceptions\RateLimitExceededException;
use App\Models\HeartReaction;
use App\Models\Pet;
use Illuminate\Support\Facades\RateLimiter;

class AddHeartReactionAction
{
    public function execute(Pet $pet, string $ipAddress, ?string $userAgent = null): HeartReaction
    {
        // Rate limiting: 1 heart per IP per pet
        $key = 'heart-reaction:'.$pet->id.':'.$ipAddress;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            throw new RateLimitExceededException('You have already sent a heart to this pet.');
        }

        // Check if already reacted
        $existing = HeartReaction::where('pet_id', $pet->id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existing) {
            throw new RateLimitExceededException('You have already sent a heart to this pet.');
        }

        $reaction = HeartReaction::create([
            'pet_id' => $pet->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        // Rate limiter: block for 1 year (permanent for this pet)
        RateLimiter::hit($key, 31536000); // 1 year in seconds

        return $reaction;
    }
}
