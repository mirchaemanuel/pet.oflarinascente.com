<?php

declare(strict_types=1);

namespace App\Actions\Reactions;

use App\Exceptions\RateLimitExceededException;
use App\Models\Pet;
use App\Models\VirtualCandle;
use Illuminate\Support\Facades\RateLimiter;

class LightVirtualCandleAction
{
    public function execute(
        Pet $pet,
        string $ipAddress,
        ?string $litByName = null,
        ?string $message = null,
        ?int $daysToExpire = 7
    ): VirtualCandle {
        // Rate limiting: max 3 candles per hour per IP
        $key = 'light-candle:'.$ipAddress;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            throw new RateLimitExceededException('Too many candles lit. Please try again later.');
        }

        $candle = VirtualCandle::create([
            'pet_id' => $pet->id,
            'lit_by_name' => $litByName,
            'message' => $message,
            'ip_address' => $ipAddress,
            'expires_at' => $daysToExpire ? now()->addDays($daysToExpire) : null,
        ]);

        RateLimiter::hit($key, 3600); // 1 hour

        return $candle;
    }
}
