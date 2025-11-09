<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PetSpecies;
use App\Traits\LogsActivityAllDirty;
use Database\Factories\PetFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @method static PetFactory factory($count = null, $state = [])
 * @method static Builder<Pet> published()
 * @method static Builder<Pet> bySpecies(PetSpecies $species)
 */
class Pet extends Model
{
    /** @use HasFactory<PetFactory> */
    use HasFactory;

    use LogsActivityAllDirty;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'species',
        'breed',
        'birth_date',
        'death_date',
        'age_years',
        'age_months',
        'dedication',
        'story',
        'owner_name',
        'owner_email',
        'owner_phone',
        'is_published',
        'published_at',
    ];

    // Relationships

    /**
     * @return HasMany<PetPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PetPhoto::class)->orderBy('order');
    }

    /**
     * @return HasMany<HeartReaction, $this>
     */
    public function heartReactions(): HasMany
    {
        return $this->hasMany(HeartReaction::class);
    }

    /**
     * @return HasMany<VirtualCandle, $this>
     */
    public function virtualCandles(): HasMany
    {
        return $this->hasMany(VirtualCandle::class);
    }

    /**
     * @return HasMany<VirtualCandle, $this>
     */
    public function activeCandles(): HasMany
    {
        return $this->virtualCandles()
            ->where(function ($query): void {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    // Scopes

    /**
     * @param  Builder<Pet>  $query
     * @return Builder<Pet>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    /**
     * @param  Builder<Pet>  $query
     * @return Builder<Pet>
     */
    public function scopeBySpecies(Builder $query, PetSpecies $species): Builder
    {
        return $query->where('species', $species);
    }

    // Accessors

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getPrimaryPhotoAttribute(): ?PetPhoto
    {
        return $this->photos()->where('is_primary', true)->first()
            ?? $this->photos()->first();
    }

    public function getAgeDisplayAttribute(): string
    {
        $parts = [];

        if ($this->age_years > 0) {
            $parts[] = $this->age_years.' '.($this->age_years === 1 ? 'anno' : 'anni');
        }

        if ($this->age_months > 0) {
            $parts[] = $this->age_months.' '.($this->age_months === 1 ? 'mese' : 'mesi');
        }

        return implode(' e ', $parts) ?: 'Età non specificata';
    }

    protected static function booted(): void
    {
        static::creating(function (Pet $pet): void {
            if (! $pet->uuid) {
                $pet->uuid = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'species' => PetSpecies::class,
            'birth_date' => 'date',
            'death_date' => 'date',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'hearts_count' => 'integer',
            'candles_count' => 'integer',
        ];
    }
}
