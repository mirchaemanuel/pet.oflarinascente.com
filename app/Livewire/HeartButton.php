<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Reactions\AddHeartReactionAction;
use App\Exceptions\RateLimitExceededException;
use App\Models\HeartReaction;
use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HeartButton extends Component
{
    public Pet $pet;

    private AddHeartReactionAction $addHeartReactionAction;

    /**
     * Bootstrap the component with dependency injection
     */
    public function boot(AddHeartReactionAction $addHeartReactionAction): void
    {
        $this->addHeartReactionAction = $addHeartReactionAction;
    }

    /**
     * Mount the component with the pet model
     */
    public function mount(Pet $pet): void
    {
        $this->pet = $pet;
    }

    /**
     * Add a heart reaction to the pet
     */
    public function addHeart(): void
    {
        try {
            $this->addHeartReactionAction->execute(
                $this->pet,
                request()->ip() ?? '127.0.0.1',
                request()->userAgent()
            );

            $this->pet->refresh();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Grazie per aver inviato un cuore a '.$this->pet->name.'!',
            ]);
        } catch (RateLimitExceededException) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Hai già inviato un cuore a '.$this->pet->name.'.',
            ]);
        }
    }

    /**
     * Check if the current visitor can add a heart reaction
     */
    #[Computed]
    public function canAddHeart(): bool
    {
        $ipAddress = request()->ip() ?? '127.0.0.1';

        return ! HeartReaction::query()
            ->where('pet_id', $this->pet->id)
            ->where('ip_address', $ipAddress)
            ->exists();
    }

    /**
     * Get the total hearts count for the pet
     */
    #[Computed]
    public function heartsCount(): int
    {
        return $this->pet->heartReactions()->count();
    }

    public function render(): View
    {
        return view('livewire.heart-button');
    }
}
