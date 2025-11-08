<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @method static PostFactory factory($count = null, $state = [])
 * @method static Builder<Post> published()
 * @method static Builder<Post> recent()
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use LogsActivityAllDirty;
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'reading_time_minutes',
        'is_published',
        'published_at',
        'meta_description',
        'meta_keywords',
    ];

    // Relationships

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Route Key

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post): void {
            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
