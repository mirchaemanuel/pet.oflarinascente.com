<?php

declare(strict_types=1);

use App\Livewire\HeartButton;
use App\Models\HeartReaction;
use App\Models\Pet;
use Livewire\Livewire;

test('heart button renders successfully', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(HeartButton::class, ['pet' => $pet])
        ->assertSuccessful()
        ->assertSee('Invia un Cuore');
});

test('can add heart when user has not reacted', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act
    $component = Livewire::test(HeartButton::class, ['pet' => $pet]);

    // Assert
    expect($component->canAddHeart)->toBeTrue();
    $component->assertSee('Invia un Cuore');
});

test('cannot add heart when user has already reacted', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    HeartReaction::factory()->create([
        'pet_id' => $pet->id,
        'ip_address' => '127.0.0.1',
    ]);

    // Act
    $component = Livewire::test(HeartButton::class, ['pet' => $pet]);

    // Assert
    expect($component->canAddHeart)->toBeFalse();
    $component->assertSee('Cuore Inviato');
});

test('successfully adds heart reaction', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act
    Livewire::test(HeartButton::class, ['pet' => $pet])
        ->call('addHeart')
        ->assertDispatched('notify');

    // Assert
    expect(HeartReaction::query()->where('pet_id', $pet->id)->count())->toBe(1);
});

test('displays hearts count', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    HeartReaction::factory()->count(5)->create([
        'pet_id' => $pet->id,
    ]);

    // Act
    $component = Livewire::test(HeartButton::class, ['pet' => $pet]);

    // Assert
    expect($component->heartsCount)->toBe(5);
    $component->assertSee('5');
});

test('prevents duplicate heart from same IP address', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    HeartReaction::factory()->create([
        'pet_id' => $pet->id,
        'ip_address' => '127.0.0.1',
    ]);

    // Act
    Livewire::test(HeartButton::class, ['pet' => $pet])
        ->call('addHeart')
        ->assertDispatched('notify');

    // Assert - should still only have 1 heart
    expect(HeartReaction::query()->where('pet_id', $pet->id)->count())->toBe(1);
});

test('button is disabled when user has already reacted', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    HeartReaction::factory()->create([
        'pet_id' => $pet->id,
        'ip_address' => '127.0.0.1',
    ]);

    // Act & Assert
    Livewire::test(HeartButton::class, ['pet' => $pet])
        ->assertSee('disabled');
});

test('shows loading state during heart submission', function (): void {
    // Arrange
    $pet = Pet::factory()->published()->create();

    // Act & Assert
    Livewire::test(HeartButton::class, ['pet' => $pet])
        ->assertSee('Invio in corso...');
});
