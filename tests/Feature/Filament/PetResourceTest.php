<?php

declare(strict_types=1);

use App\Filament\Resources\Pets\Pages\CreatePet;
use App\Filament\Resources\Pets\Pages\EditPet;
use App\Filament\Resources\Pets\Pages\ListPets;
use App\Models\Pet;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

describe('List Pets', function (): void {
    it('can load the list page', function (): void {
        // Arrange
        $pets = Pet::factory()->count(5)->create();

        // Act & Assert
        livewire(ListPets::class)
            ->assertOk()
            ->assertCanSeeTableRecords($pets);
    });

    it('can search pets by name', function (): void {
        // Arrange
        $uniquePet = Pet::factory()->create(['name' => 'UniqueTestPetName123']);
        $otherPets = Pet::factory()->count(3)->create();

        // Act & Assert
        livewire(ListPets::class)
            ->searchTable('UniqueTestPetName123')
            ->assertCanSeeTableRecords([$uniquePet])
            ->assertCanNotSeeTableRecords($otherPets);
    });

    it('can filter pets by published status', function (): void {
        // Arrange
        $publishedPets = Pet::factory()->count(3)->create([
            'is_published' => true,
            'published_at' => now(),
        ]);
        $unpublishedPets = Pet::factory()->count(2)->create([
            'is_published' => false,
        ]);

        // Act & Assert
        livewire(ListPets::class)
            ->filterTable('is_published', true)
            ->assertCanSeeTableRecords($publishedPets)
            ->assertCanNotSeeTableRecords($unpublishedPets);
    });

    it('can filter pets by species', function (): void {
        // Arrange
        $dogs = Pet::factory()->count(3)->create(['species' => 'dog']);
        $cats = Pet::factory()->count(2)->create(['species' => 'cat']);

        // Act & Assert
        livewire(ListPets::class)
            ->filterTable('species', 'dog')
            ->assertCanSeeTableRecords($dogs)
            ->assertCanNotSeeTableRecords($cats);
    });
});

describe('Create Pet', function (): void {
    it('can load the create page', function (): void {
        // Act & Assert
        livewire(CreatePet::class)
            ->assertOk();
    });

    it('can create a pet', function (): void {
        // Arrange
        $newPetData = Pet::factory()->make();

        // Act & Assert
        livewire(CreatePet::class)
            ->set('data.name', $newPetData->name)
            ->set('data.species', $newPetData->species)
            ->set('data.birth_date', $newPetData->birth_date)
            ->set('data.death_date', $newPetData->death_date)
            ->set('data.owner_name', $newPetData->owner_name)
            ->set('data.dedication', $newPetData->dedication)
            ->set('data.is_published', $newPetData->is_published)
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        // Verify database
        assertDatabaseHas(Pet::class, [
            'name' => $newPetData->name,
            'species' => $newPetData->species,
        ]);
    });

    it('validates required fields', function (array $data, array $errors): void {
        // Arrange
        $newPetData = Pet::factory()->make();

        // Act & Assert
        livewire(CreatePet::class)
            ->fillForm([
                'name' => $newPetData->name,
                'species' => $newPetData->species,
                ...$data,
            ])
            ->call('create')
            ->assertHasFormErrors($errors)
            ->assertNotNotified()
            ->assertNoRedirect();
    })->with([
        'name is required' => [['name' => null], ['name' => 'required']],
        'species is required' => [['species' => null], ['species' => 'required']],
    ]);
});

describe('Edit Pet', function (): void {
    it('can load the edit page', function (): void {
        // Arrange
        $pet = Pet::factory()->create();

        // Act & Assert
        livewire(EditPet::class, [
            'record' => $pet->getRouteKey(),
        ])
            ->assertOk()
            ->assertSchemaStateSet([
                'name' => $pet->name,
                'species' => $pet->species,
                'is_published' => $pet->is_published,
            ]);
    });

    it('can update a pet', function (): void {
        // Arrange
        $pet = Pet::factory()->create();
        $newName = fake()->firstName();

        // Act & Assert
        livewire(EditPet::class, [
            'record' => $pet->getRouteKey(),
        ])
            ->set('data.name', $newName)
            ->set('data.dedication', 'Updated dedication')
            ->call('save')
            ->assertNotified();

        // Verify database
        assertDatabaseHas(Pet::class, [
            'id' => $pet->id,
            'name' => $newName,
        ]);
    });

    it('can publish a pet memorial', function (): void {
        // Arrange
        $pet = Pet::factory()->create([
            'is_published' => false,
        ]);

        // Act & Assert
        livewire(EditPet::class, [
            'record' => $pet->getRouteKey(),
        ])
            ->set('data.is_published', true)
            ->call('save')
            ->assertNotified();

        // Verify database
        $pet->refresh();
        expect($pet->is_published)->toBeTrue()
            ->and($pet->published_at)->not->toBeNull();
    });

    it('can delete a pet memorial', function (): void {
        // Arrange
        $pet = Pet::factory()->create();

        // Act & Assert
        livewire(EditPet::class, [
            'record' => $pet->getRouteKey(),
        ])
            ->callAction('delete')
            ->assertNotified()
            ->assertRedirect();

        // Verify soft delete
        expect($pet->fresh()->trashed())->toBeTrue();
    });
});
