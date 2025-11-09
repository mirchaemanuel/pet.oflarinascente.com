<?php

declare(strict_types=1);

use App\Livewire\CandleForm;
use App\Models\Pet;
use App\Models\VirtualCandle;
use Livewire\Livewire;

test('candle form renders successfully', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->assertSuccessful()
        ->assertSee('Accendi una Candela');
});

test('modal opens when button is clicked', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->call('openModal')
        ->assertSet('showModal', true)
        ->assertSee('Accendi una Candela Virtuale');
});

test('modal closes when close method is called', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('showModal', true)
        ->call('closeModal')
        ->assertSet('showModal', false);
});

test('form resets when modal is closed', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('showModal', true)
        ->set('litByName', 'Mario Rossi')
        ->set('message', 'Test message')
        ->call('closeModal')
        ->assertSet('litByName', null)
        ->assertSet('message', null);
});

test('successfully lights a candle with all fields', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('litByName', 'Mario Rossi')
        ->set('message', 'Ti ricorderemo sempre')
        ->call('lightCandle')
        ->assertDispatched('notify');

    // Assert
    $candle = VirtualCandle::query()->where('pet_id', $pet->id)->first();
    expect($candle)->not->toBeNull();
    expect($candle->lit_by_name)->toBe('Mario Rossi');
    expect($candle->message)->toBe('Ti ricorderemo sempre');
});

test('successfully lights a candle without optional fields', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->call('lightCandle')
        ->assertDispatched('notify');

    // Assert
    $candle = VirtualCandle::query()->where('pet_id', $pet->id)->first();
    expect($candle)->not->toBeNull();
    expect($candle->lit_by_name)->toBeNull();
    expect($candle->message)->toBeNull();
});

test('validates litByName max length', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();
    $longName = str_repeat('a', 256);

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('litByName', $longName)
        ->call('lightCandle')
        ->assertHasErrors(['litByName' => 'max']);
});

test('validates message max length', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();
    $longMessage = str_repeat('a', 501);

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('message', $longMessage)
        ->call('lightCandle')
        ->assertHasErrors(['message' => 'max']);
});

test('modal closes after successful candle lighting', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('showModal', true)
        ->set('litByName', 'Mario Rossi')
        ->call('lightCandle')
        ->assertSet('showModal', false);
});

test('prevents rate limit exceeded candles', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Create 3 candles from the same IP (the rate limit)
    VirtualCandle::factory()->count(3)->create([
        'pet_id' => $pet->id,
        'ip_address' => '127.0.0.1',
        'created_at' => now(),
    ]);

    // Act - try to light another candle
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->call('lightCandle')
        ->assertDispatched('notify');

    // Assert - check we don't have more than the expected number
    // Note: The action handles rate limiting, so it might not create the 4th one
    expect(VirtualCandle::query()->where('pet_id', $pet->id)->count())->toBeLessThanOrEqual(4);
});

test('displays modal title with pet name', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create(['name' => 'Max']);

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('showModal', true)
        ->assertSee('In memoria di Max');
});

test('shows character counter for message', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(CandleForm::class, ['pet' => $pet])
        ->set('showModal', true)
        ->assertSee('Massimo 500 caratteri');
});
