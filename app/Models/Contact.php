<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static ContactFactory factory($count = null, $state = [])
 */
class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    // Helpers

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsReplied(): void
    {
        $this->update([
            'replied_at' => now(),
        ]);
    }

    // Scopes

    /**
     * @param  Builder<Contact>  $query
     * @return Builder<Contact>
     */
    #[Scope]
    protected function unread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * @param  Builder<Contact>  $query
     * @return Builder<Contact>
     */
    #[Scope]
    protected function read(Builder $query): Builder
    {
        return $query->where('is_read', true);
    }

    /**
     * @param  Builder<Contact>  $query
     * @return Builder<Contact>
     */
    #[Scope]
    protected function recent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'replied_at' => 'datetime',
        ];
    }
}
