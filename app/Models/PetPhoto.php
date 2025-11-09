<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\PetPhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @method static PetPhotoFactory factory($count = null, $state = [])
 */
class PetPhoto extends Model
{
    /** @use HasFactory<PetPhotoFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    protected $fillable = [
        'pet_id',
        'path',
        'disk',
        'is_primary',
        'order',
    ];

    // Relationships

    /**
     * @return BelongsTo<Pet, $this>
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    // Accessors

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'order' => 'integer',
        ];
    }
}
