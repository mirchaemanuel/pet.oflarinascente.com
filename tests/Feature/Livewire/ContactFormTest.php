<?php

declare(strict_types=1);

use App\Livewire\ContactForm;
use App\Models\Contact;
use Livewire\Livewire;

test('contact form renders successfully', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->assertSuccessful();
});

test('successfully submits contact form with all fields', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Mario Rossi',
        'email' => 'mario@example.com',
        'phone' => '333-1234567',
        'subject' => 'Richiesta Informazioni',
        'message' => 'Vorrei avere maggiori informazioni sui vostri servizi.',
    ];

    // Act
    Livewire::test(ContactForm::class)
        ->set('name', $contactData['name'])
        ->set('email', $contactData['email'])
        ->set('phone', $contactData['phone'])
        ->set('subject', $contactData['subject'])
        ->set('message', $contactData['message'])
        ->call('submit')
        ->assertDispatched('notify');

    // Assert
    $this->assertDatabaseHas('contacts', [
        'name' => $contactData['name'],
        'email' => $contactData['email'],
        'phone' => $contactData['phone'],
        'subject' => $contactData['subject'],
        'message' => $contactData['message'],
    ]);

    expect(Contact::count())->toBe(1);

    $contact = Contact::first();
    expect($contact->name)->toBe($contactData['name'])
        ->and($contact->email)->toBe($contactData['email'])
        ->and($contact->phone)->toBe($contactData['phone'])
        ->and($contact->subject)->toBe($contactData['subject'])
        ->and($contact->message)->toBe($contactData['message'])
        ->and($contact->ip_address)->not->toBeNull()
        ->and($contact->user_agent)->not->toBeNull()
        ->and($contact->is_read)->toBeFalse();
});

test('successfully submits contact form without optional phone field', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Giulia Bianchi',
        'email' => 'giulia@example.com',
        'phone' => null,
        'subject' => 'Domanda Servizi',
        'message' => 'Vorrei sapere i prezzi.',
    ];

    // Act
    Livewire::test(ContactForm::class)
        ->set('name', $contactData['name'])
        ->set('email', $contactData['email'])
        ->set('subject', $contactData['subject'])
        ->set('message', $contactData['message'])
        ->call('submit')
        ->assertDispatched('notify');

    // Assert
    $this->assertDatabaseHas('contacts', [
        'name' => $contactData['name'],
        'email' => $contactData['email'],
        'phone' => null,
        'subject' => $contactData['subject'],
        'message' => $contactData['message'],
    ]);

    expect(Contact::count())->toBe(1);
});

test('resets form after successful submission', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Luigi Verdi',
        'email' => 'luigi@example.com',
        'phone' => '333-7654321',
        'subject' => 'Informazioni',
        'message' => 'Messaggio di prova',
    ];

    // Act
    Livewire::test(ContactForm::class)
        ->set('name', $contactData['name'])
        ->set('email', $contactData['email'])
        ->set('phone', $contactData['phone'])
        ->set('subject', $contactData['subject'])
        ->set('message', $contactData['message'])
        ->call('submit')
        ->assertSet('name', null)
        ->assertSet('email', null)
        ->assertSet('phone', null)
        ->assertSet('subject', null)
        ->assertSet('message', null)
        ->assertSet('showSuccessMessage', true);
});

test('validates required name field', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', '')
        ->set('email', 'test@example.com')
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);

    expect(Contact::count())->toBe(0);
});

test('validates required email field', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', '')
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['email' => 'required']);

    expect(Contact::count())->toBe(0);
});

test('validates email format', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'not-an-email')
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['email' => 'email']);

    expect(Contact::count())->toBe(0);
});

test('validates required subject field', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('subject', '')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['subject' => 'required']);

    expect(Contact::count())->toBe(0);
});

test('validates required message field', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('subject', 'Test')
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['message' => 'required']);

    expect(Contact::count())->toBe(0);
});

test('validates name max length', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', str_repeat('a', 256))
        ->set('email', 'test@example.com')
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['name' => 'max']);

    expect(Contact::count())->toBe(0);
});

test('validates email max length', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', str_repeat('a', 246).'@example.com')
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['email' => 'max']);

    expect(Contact::count())->toBe(0);
});

test('validates phone max length', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', str_repeat('1', 21))
        ->set('subject', 'Test')
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['phone' => 'max']);

    expect(Contact::count())->toBe(0);
});

test('validates subject max length', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('subject', str_repeat('a', 256))
        ->set('message', 'Test message')
        ->call('submit')
        ->assertHasErrors(['subject' => 'max']);

    expect(Contact::count())->toBe(0);
});

test('validates message max length', function (): void {
    // Act & Assert
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('subject', 'Test')
        ->set('message', str_repeat('a', 5001))
        ->call('submit')
        ->assertHasErrors(['message' => 'max']);

    expect(Contact::count())->toBe(0);
});

test('stores IP address and user agent', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'Test message content',
    ];

    // Act
    Livewire::test(ContactForm::class)
        ->set('name', $contactData['name'])
        ->set('email', $contactData['email'])
        ->set('subject', $contactData['subject'])
        ->set('message', $contactData['message'])
        ->call('submit');

    // Assert
    $contact = Contact::first();
    expect($contact->ip_address)->not->toBeNull()
        ->and($contact->user_agent)->not->toBeNull();
});

test('contact starts as unread', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'Test message content',
    ];

    // Act
    Livewire::test(ContactForm::class)
        ->set('name', $contactData['name'])
        ->set('email', $contactData['email'])
        ->set('subject', $contactData['subject'])
        ->set('message', $contactData['message'])
        ->call('submit');

    // Assert
    $contact = Contact::first();
    expect($contact->is_read)->toBeFalse();
});
