<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BookingStatus;
use App\Traits\LogsActivityAllDirty;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static BookingFactory factory($count = null, $state = [])
 * @method static Builder<Booking> byStatus(BookingStatus $status)
 * @method static Builder<Booking> pending()
 * @method static Builder<Booking> confirmed()
 * @method static Builder<Booking> recent()
 *
 * @property BookingStatus $status
 */
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    protected $fillable = [
        'service_id',
        'pet_name',
        'pet_species',
        'pet_breed',
        'pet_weight_kg',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'preferred_date',
        'preferred_time',
        'message',
        'special_requests',
        'status',
        'notes',
        'confirmed_at',
        'completed_at',
    ];

    // Relationships

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Scopes

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeByStatus(Builder $query, BookingStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', BookingStatus::Pending);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', BookingStatus::Confirmed);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
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
