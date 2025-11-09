<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BookingStatus;
use App\Traits\LogsActivityAllDirty;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static BookingFactory factory($count = null, $state = [])
 *
 * @property BookingStatus $status
 */
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    // Relationships

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Status Helpers

    public function isPending(): bool
    {
        return $this->status === BookingStatus::Pending;
    }

    public function isConfirmed(): bool
    {
        return $this->status === BookingStatus::Confirmed;
    }

    public function isCompleted(): bool
    {
        return $this->status === BookingStatus::Completed;
    }

    public function isCancelled(): bool
    {
        return $this->status === BookingStatus::Cancelled;
    }

    // State Transitions

    public function confirm(): void
    {
        $this->update([
            'status' => BookingStatus::Confirmed,
            'confirmed_at' => now(),
        ]);
    }

    public function markInProgress(): void
    {
        $this->update([
            'status' => BookingStatus::InProgress,
        ]);
    }

    public function complete(): void
    {
        $this->update([
            'status' => BookingStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => BookingStatus::Cancelled,
        ]);
    }

    // Scopes

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    #[Scope]
    protected function byStatus(Builder $query, BookingStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    #[Scope]
    protected function pending(Builder $query): Builder
    {
        return $query->where('status', BookingStatus::Pending);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    #[Scope]
    protected function confirmed(Builder $query): Builder
    {
        return $query->where('status', BookingStatus::Confirmed);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    #[Scope]
    protected function recent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    protected function casts(): array
    {
        return [
            'status' => BookingStatus::class,
            'pet_weight_kg' => 'decimal:2',
            'preferred_date' => 'date',
            'confirmed_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
