<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Contacts\SubmitContactFormAction;
use App\Data\ContactData;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContactForm extends Component
{
    public ?string $name = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $subject = null;

    public ?string $message = null;

    public bool $showSuccessMessage = false;

    private SubmitContactFormAction $submitContactFormAction;

    /**
     * Bootstrap the component with dependency injection
     */
    public function boot(SubmitContactFormAction $submitContactFormAction): void
    {
        $this->submitContactFormAction = $submitContactFormAction;
    }

    /**
     * Submit the contact form
     */
    public function submit(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $this->submitContactFormAction->execute(
            ContactData::from($validated),
            request()->ip() ?? '127.0.0.1',
            request()->userAgent()
        );

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->showSuccessMessage = true;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Grazie per averci contattato. Ti risponderemo al più presto!',
        ]);
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
