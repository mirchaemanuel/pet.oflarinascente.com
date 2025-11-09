<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Reactions\AddHeartReactionAction;
use App\Actions\Reactions\LightVirtualCandleAction;
use App\Models\HeartReaction;
use App\Models\Pet;
use App\Models\VirtualCandle;

class ReactionService
{
    public function __construct(
        private readonly AddHeartReactionAction $addHeartAction,
        private readonly LightVirtualCandleAction $lightCandleAction,
    ) {}

    /**
     * Add a heart reaction to a pet memorial
     */
    public function addHeart(Pet $pet, string $ipAddress, ?string $userAgent = null): HeartReaction
    {
        return $this->addHeartAction->execute($pet, $ipAddress, $userAgent);
    }

    /**
     * Light a virtual candle for a pet
     */
    public function lightCandle(
        Pet $pet,
        string $ipAddress,
        ?string $litByName = null,
        ?string $message = null,
        int $daysToExpire = 7
    ): VirtualCandle {
        return $this->lightCandleAction->execute($pet, $ipAddress, $litByName, $message, $daysToExpire);
    }

    /**
     * Check if an IP can add a heart to a pet
     */
    public function canAddHeart(Pet $pet, string $ipAddress): bool
    {
        return ! HeartReaction::where('pet_id', $pet->id)
            ->where('ip_address', $ipAddress)
            ->exists();
    }

    /**
     * Cleanup expired candles
     */
    public function cleanupExpiredCandles(): int
    {
        return VirtualCandle::expired()->delete();
    }
}
