<?php

declare(strict_types=1);

use App\Livewire\MemorialDetail;
use App\Models\HeartReaction;
use App\Models\Pet;
use App\Models\VirtualCandle;
use Livewire\Livewire;

use function Pest\Laravel\get;

test('memorial detail page renders successfully', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create(['name' => 'Test Pet']);

    // Act
    $response = get(route('memorials.show', $pet));

    // Assert
    $response->assertSuccessful();
    $response->assertSee('Test Pet');
});

test('memorial detail displays pet information', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create([
            'name' => 'Max',
            'dedication' => 'Forever in our hearts',
            'story' => 'Max was a loyal companion',
        ]);

    // Act & Assert
    Livewire::test(MemorialDetail::class, ['pet' => $pet])
        ->assertSee('Max')
        ->assertSee('Forever in our hearts')
        ->assertSee('Max was a loyal companion');
});

test('memorial detail shows hearts count', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create(['hearts_count' => 5]);

    // Act & Assert
    Livewire::test(MemorialDetail::class, ['pet' => $pet])
        ->assertSee('5');
});

test('memorial detail shows active candles count', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create();

    VirtualCandle::factory()
        ->count(3)
        ->create([
            'pet_id' => $pet->id,
            'expires_at' => now()->addDays(7),
        ]);

    VirtualCandle::factory()
        ->create([
            'pet_id' => $pet->id,
            'expires_at' => now()->subDays(1), // Expired
        ]);

    // Act
    $component = Livewire::test(MemorialDetail::class, ['pet' => $pet]);

    // Assert
    expect($component->activeCandlesCount)->toBe(3);
});

test('can add heart checks if user has already reacted', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create();

    HeartReaction::factory()->create([
        'pet_id' => $pet->id,
        'ip_address' => '127.0.0.1',
    ]);

    // Act
    $component = Livewire::test(MemorialDetail::class, ['pet' => $pet]);

    // Assert
    expect($component->canAddHeart)->toBeFalse();
});

test('can add heart returns true if user has not reacted', function (): void {
    // Arrange
    $pet = Pet::factory()
        ->published()
        ->create();

    // Act
    $component = Livewire::test(MemorialDetail::class, ['pet' => $pet]);

    // Assert
    expect($component->canAddHeart)->toBeTrue();
});
