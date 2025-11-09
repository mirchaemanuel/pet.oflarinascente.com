<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\HeartReactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static HeartReactionFactory factory($count = null, $state = [])
 */
class HeartReaction extends Model
{
    /** @use HasFactory<HeartReactionFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    // Relationships

    /**
     * @return BelongsTo<Pet, $this>
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    // Events

    protected static function booted(): void
    {
        static::created(function (HeartReaction $reaction): void {
            $reaction->pet()->increment('hearts_count');
        });

        static::deleted(function (HeartReaction $reaction): void {
            $reaction->pet()->decrement('hearts_count');
        });
    }
}
