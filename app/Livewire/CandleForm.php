<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Reactions\LightVirtualCandleAction;
use App\Exceptions\RateLimitExceededException;
use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CandleForm extends Component
{
    public Pet $pet;

    public ?string $litByName = null;

    public ?string $message = null;

    public bool $showModal = false;

    private LightVirtualCandleAction $lightVirtualCandleAction;

    /**
     * Bootstrap the component with dependency injection
     */
    public function boot(LightVirtualCandleAction $lightVirtualCandleAction): void
    {
        $this->lightVirtualCandleAction = $lightVirtualCandleAction;
    }

    /**
     * Mount the component with the pet model
     */
    public function mount(Pet $pet): void
    {
        $this->pet = $pet;
    }

    /**
     * Open the modal
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Close the modal and reset form
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['litByName', 'message']);
        $this->resetValidation();
    }

    /**
     * Light a virtual candle for the pet
     */
    public function lightCandle(): void
    {
        $this->validate([
            'litByName' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $this->lightVirtualCandleAction->execute(
                $this->pet,
                request()->ip() ?? '127.0.0.1',
                $this->litByName,
                $this->message
            );

            $this->pet->refresh();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Grazie per aver acceso una candela per '.$this->pet->name.'.',
            ]);

            $this->closeModal();
        } catch (RateLimitExceededException) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Hai acceso troppe candele. Riprova più tardi.',
            ]);
        }
    }

    public function render(): View
    {
        return view('livewire.candle-form');
    }
}
