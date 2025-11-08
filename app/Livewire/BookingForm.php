<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Bookings\CreateBookingAction;
use App\Data\BookingData;
use App\Models\Service;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class BookingForm extends Component
{
    public ?int $service_id = null;

    public ?string $customer_name = null;

    public ?string $customer_email = null;

    public ?string $customer_phone = null;

    public ?string $pet_name = null;

    public ?string $pet_species = null;

    public ?string $preferred_date = null;

    public ?string $notes = null;

    public bool $showSuccessMessage = false;

    private CreateBookingAction $createBookingAction;

    /**
     * Bootstrap the component with dependency injection
     */
    public function boot(CreateBookingAction $createBookingAction): void
    {
        $this->createBookingAction = $createBookingAction;
    }

    /**
     * Mount the component
     */
    public function mount(?string $service = null): void
    {
        if ($service) {
            $this->service_id = (int) $service;
        }
    }

    /**
     * Get available services
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Service>
     */
    public function getServicesProperty(): Collection
    {
        return Service::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }

    /**
     * Submit the booking form
     */
    public function submit(): void
    {
        $validated = $this->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'pet_name' => ['nullable', 'string', 'max:255'],
            'pet_species' => ['nullable', 'string', 'max:100'],
            'preferred_date' => ['nullable', 'date', 'after:today'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $this->createBookingAction->execute(
            BookingData::from([
                'serviceId' => $validated['service_id'],
                'petName' => $validated['pet_name'],
                'petSpecies' => $validated['pet_species'],
                'petBreed' => null,
                'petWeightKg' => null,
                'customerName' => $validated['customer_name'],
                'customerEmail' => $validated['customer_email'],
                'customerPhone' => $validated['customer_phone'],
                'customerAddress' => null,
                'preferredDate' => $validated['preferred_date'] ? new DateTime($validated['preferred_date']) : null,
                'preferredTime' => null,
                'message' => $validated['notes'],
                'specialRequests' => null,
            ])
        );

        $this->reset([
            'service_id',
            'customer_name',
            'customer_email',
            'customer_phone',
            'pet_name',
            'pet_species',
            'preferred_date',
            'notes',
        ]);

        $this->showSuccessMessage = true;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'La tua richiesta è stata inviata con successo. Ti contatteremo a breve!',
        ]);
    }

    public function render(): View
    {
        return view('livewire.booking-form');
    }
}
