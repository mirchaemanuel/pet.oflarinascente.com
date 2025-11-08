<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\VirtualCandleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property \Illuminate\Support\Carbon|null $expires_at
 *
 * @method static VirtualCandleFactory factory($count = null, $state = [])
 * @method static Builder<VirtualCandle> active()
 * @method static Builder<VirtualCandle> expired()
 */
class VirtualCandle extends Model
{
    /** @use HasFactory<VirtualCandleFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    protected $fillable = [
        'pet_id',
        'lit_by_name',
        'message',
        'ip_address',
        'expires_at',
    ];

    // Relationships

    /**
     * @return BelongsTo<Pet, $this>
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    // Scopes

    /**
     * @param  Builder<VirtualCandle>  $query
     * @return Builder<VirtualCandle>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(function ($query): void {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * @param  Builder<VirtualCandle>  $query
     * @return Builder<VirtualCandle>
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());
    }

    // Helpers

    public function isActive(): bool
    {
        if ($this->expires_at === null) {
            return true;
        }

        return $this->expires_at->isFuture();
    }

    // Events

    protected static function booted(): void
    {
        static::created(function (VirtualCandle $candle): void {
            $candle->pet()->increment('candles_count');
        });

        static::deleted(function (VirtualCandle $candle): void {
            $candle->pet()->decrement('candles_count');
        });
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
