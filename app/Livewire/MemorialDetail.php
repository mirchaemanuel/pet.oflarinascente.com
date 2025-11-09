<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class MemorialDetail extends Component
{
    public Pet $pet;

    /**
     * Mount the component with the pet model
     */
    public function mount(Pet $pet): void
    {
        $this->pet = $pet->load(['photos', 'heartReactions', 'activeCandles']);
    }

    /**
     * Get the count of active candles
     */
    #[Computed]
    public function activeCandlesCount(): int
    {
        return $this->pet->activeCandles()->count();
    }

    /**
     * Check if the current user can add a heart reaction
     */
    #[Computed]
    public function canAddHeart(): bool
    {
        $ipAddress = request()->ip();

        return ! $this->pet->heartReactions()
            ->where('ip_address', $ipAddress)
            ->exists();
    }

    public function render(): View
    {
        return view('livewire.memorial-detail')
            ->layout('layouts.app');
    }
}
