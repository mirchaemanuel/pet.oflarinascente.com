<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @method static ServiceFactory factory($count = null, $state = [])
 */
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    use LogsActivityAllDirty;
    use SoftDeletes;

    // Relationships

    /**
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Route Key

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Service $service): void {
            if (! $service->slug) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    // Scopes

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    #[Scope]
    protected function ordered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('name');
    }

    protected function casts(): array
    {
        return [
            'price_from' => 'decimal:2',
            'is_active' => 'boolean',
            'order' => 'integer',
            'features' => 'array',
        ];
    }
}
