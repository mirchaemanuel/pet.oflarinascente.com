<?php

declare(strict_types=1);

use App\Enums\PetSpecies;
use App\Livewire\MemorialGallery;
use App\Models\Pet;
use Livewire\Livewire;

use function Pest\Laravel\get;

test('memorial gallery page renders successfully', function (): void {
    // Arrange
    $pets = Pet::factory()
        ->count(3)
        ->published()
        ->create();

    // Act
    $response = get(route('memorials.index'));

    // Assert
    $response->assertSuccessful();
    $response->assertSee('Cimitero Virtuale');
});

test('memorial gallery displays published pets', function (): void {
    // Arrange
    $publishedPet = Pet::factory()
        ->published()
        ->create(['name' => 'Max the Dog']);

    $unpublishedPet = Pet::factory()
        ->create(['name' => 'Hidden Pet', 'is_published' => false]);

    // Act & Assert
    Livewire::test(MemorialGallery::class)
        ->assertSee('Max the Dog')
        ->assertDontSee('Hidden Pet');
});

test('search filters memorials by name', function (): void {
    // Arrange
    Pet::factory()
        ->published()
        ->create([
            'name' => 'Max the Golden Retriever',
            'dedication' => 'A loyal friend',
            'story' => 'He loved to play fetch',
        ]);

    Pet::factory()
        ->published()
        ->create([
            'name' => 'Whiskers the Cat',
            'dedication' => 'Forever purring in our hearts',
            'story' => 'She loved sunny windows',
        ]);

    // Act & Assert
    Livewire::test(MemorialGallery::class)
        ->set('search', 'Golden')
        ->assertSee('Max the Golden Retriever')
        ->assertDontSee('Whiskers the Cat');
});

test('species filter works correctly', function (): void {
    // Arrange
    Pet::factory()
        ->published()
        ->create(['name' => 'Max', 'species' => PetSpecies::Dog]);

    Pet::factory()
        ->published()
        ->create(['name' => 'Whiskers', 'species' => PetSpecies::Cat]);

    // Act & Assert
    Livewire::test(MemorialGallery::class)
        ->call('filterBySpecies', PetSpecies::Dog)
        ->assertSee('Max')
        ->assertDontSee('Whiskers');
});

test('pagination resets when search changes', function (): void {
    // Arrange
    Pet::factory()
        ->count(15)
        ->published()
        ->create();

    // Act & Assert
    $component = Livewire::test(MemorialGallery::class);

    // Navigate to page 2
    $component->call('gotoPage', 2);

    // Change search - should reset to page 1
    $component->set('search', 'test');

    // Verify we're back on page 1 by checking the computed property
    expect($component->memorials->currentPage())->toBe(1);
});

test('only displays species filters for published memorials', function (): void {
    // Arrange
    Pet::factory()
        ->published()
        ->create(['species' => PetSpecies::Dog]);

    Pet::factory()
        ->published()
        ->create(['species' => PetSpecies::Cat]);

    // Create an unpublished rabbit - should not appear in filters
    Pet::factory()
        ->create(['species' => PetSpecies::Rabbit, 'is_published' => false]);

    // Act & Assert
    Livewire::test(MemorialGallery::class)
        ->assertSee('Cane')
        ->assertSee('Gatto')
        ->assertDontSee('Coniglio');
});

test('species filter section is hidden when no memorials exist', function (): void {
    // Arrange - no pets

    // Act & Assert
    Livewire::test(MemorialGallery::class)
        ->assertDontSee('Tutti')
        ->assertDontSee('Cane')
        ->assertDontSee('Gatto');
});
