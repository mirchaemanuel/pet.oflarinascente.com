<?php

declare(strict_types=1);

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\Repeater;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

describe('List Services', function (): void {
    it('can load the list page', function (): void {
        // Arrange
        $services = Service::factory()->count(5)->create();

        // Act & Assert
        livewire(ListServices::class)
            ->assertOk()
            ->assertCanSeeTableRecords($services);
    });

    it('can search services by name', function (): void {
        // Arrange
        $services = Service::factory()->count(5)->create();

        // Act & Assert
        livewire(ListServices::class)
            ->assertCanSeeTableRecords($services)
            ->searchTable($services->first()->name)
            ->assertCanSeeTableRecords($services->take(1))
            ->assertCanNotSeeTableRecords($services->skip(1));
    });

    it('can filter services by active status', function (): void {
        // Arrange
        $activeServices = Service::factory()->count(3)->create(['is_active' => true]);
        $inactiveServices = Service::factory()->count(2)->create(['is_active' => false]);

        // Act & Assert
        livewire(ListServices::class)
            ->filterTable('is_active', true)
            ->assertCanSeeTableRecords($activeServices)
            ->assertCanNotSeeTableRecords($inactiveServices);
    });

    it('can sort services by name', function (): void {
        // Arrange
        $services = Service::factory()->count(5)->create();

        // Act & Assert
        livewire(ListServices::class)
            ->sortTable('name')
            ->assertCanSeeTableRecords($services->sortBy('name'), inOrder: true)
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords($services->sortByDesc('name'), inOrder: true);
    });
});

describe('Create Service', function (): void {
    it('can load the create page', function (): void {
        // Act & Assert
        livewire(CreateService::class)
            ->assertOk();
    });

    it('can create a service', function (): void {
        // Arrange
        $newServiceData = Service::factory()->make();

        // Act & Assert
        livewire(CreateService::class)
            ->set('data.name', $newServiceData->name)
            ->set('data.slug', $newServiceData->slug)
            ->set('data.description', $newServiceData->description)
            ->set('data.is_active', $newServiceData->is_active)
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        // Verify database
        assertDatabaseHas(Service::class, [
            'name' => $newServiceData->name,
            'slug' => $newServiceData->slug,
        ]);
    });

    it('validates required fields', function (array $data, array $errors): void {
        // Arrange
        $newServiceData = Service::factory()->make();

        // Act & Assert
        livewire(CreateService::class)
            ->fillForm([
                'name' => $newServiceData->name,
                'slug' => $newServiceData->slug,
                'description' => $newServiceData->description,
                ...$data,
            ])
            ->call('create')
            ->assertHasFormErrors($errors)
            ->assertNotNotified()
            ->assertNoRedirect();
    })->with([
        'name is required' => [['name' => null], ['name' => 'required']],
        'slug is required' => [['slug' => null], ['slug' => 'required']],
        'description is required' => [['description' => null], ['description' => 'required']],
    ]);

    it('auto-generates slug from name', function (): void {
        // TODO: Fix Filament reactive form testing
        expect(true)->toBeTrue();
    })->skip('Filament reactive forms need investigation');

    it('can create service with features repeater', function (): void {
        // Arrange
        $undoRepeaterFake = Repeater::fake();
        $newServiceData = Service::factory()->make([
            'features' => [
                ['feature' => 'Servizio professionale'],
                ['feature' => 'Massimo rispetto'],
                ['feature' => 'Disponibilità 24/7'],
            ],
        ]);

        // Act & Assert
        livewire(CreateService::class)
            ->set('data.name', $newServiceData->name)
            ->set('data.slug', $newServiceData->slug)
            ->set('data.description', $newServiceData->description)
            ->set('data.is_active', $newServiceData->is_active)
            ->set('data.features', $newServiceData->features)
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        // Verify database
        assertDatabaseHas(Service::class, [
            'name' => $newServiceData->name,
            'slug' => $newServiceData->slug,
        ]);

        $service = Service::where('slug', $newServiceData->slug)->first();
        expect($service->features)->toBeArray()
            ->and(array_values($service->features))->toEqual($newServiceData->features);

        $undoRepeaterFake();
    });
});

describe('Edit Service', function (): void {
    it('can load the edit page', function (): void {
        // Arrange
        $service = Service::factory()->create();

        // Act & Assert
        livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->assertOk()
            ->assertSchemaStateSet([
                'name' => $service->name,
                'slug' => $service->slug,
                'description' => $service->description,
                'is_active' => $service->is_active,
            ]);
    });

    it('can load service with features repeater', function (): void {
        // Arrange
        $service = Service::factory()->create([
            'features' => [
                ['feature' => 'Servizio professionale'],
                ['feature' => 'Massimo rispetto'],
            ],
        ]);

        // Act
        $component = livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->assertOk();

        // Assert - check that features are loaded (values not keys since Repeater uses UUIDs)
        $formData = $component->get('data');
        expect($formData['features'])->toBeArray()
            ->and(array_values($formData['features']))->toEqual([
                ['feature' => 'Servizio professionale'],
                ['feature' => 'Massimo rispetto'],
            ]);
    });

    it('can update a service', function (): void {
        // Arrange
        $service = Service::factory()->create();
        $newName = fake()->words(3, true);
        $newSlug = str($newName)->slug();

        // Act & Assert
        livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->set('data.name', $newName)
            ->set('data.slug', $newSlug)
            ->set('data.description', 'Updated description')
            ->call('save')
            ->assertNotified();

        // Verify database
        assertDatabaseHas(Service::class, [
            'id' => $service->id,
            'name' => $newName,
            'slug' => $newSlug,
        ]);
    });

    it('can update service features', function (): void {
        // Arrange
        $undoRepeaterFake = Repeater::fake();
        $service = Service::factory()->create([
            'features' => [
                ['feature' => 'Servizio vecchio'],
            ],
        ]);

        $newFeatures = [
            ['feature' => 'Servizio aggiornato'],
            ['feature' => 'Nuova caratteristica'],
        ];

        // Act & Assert
        livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->set('data.features', $newFeatures)
            ->call('save')
            ->assertNotified();

        // Verify database
        $service->refresh();
        expect(array_values($service->features))->toEqual($newFeatures);

        $undoRepeaterFake();
    });

    it('validates fields on update', function (string $field, string $error): void {
        // Arrange
        $service = Service::factory()->create();

        // Act & Assert
        livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->set("data.{$field}")
            ->call('save')
            ->assertHasFormErrors(["{$field}" => $error]);
    })->with([
        'name is required' => ['name', 'required'],
        'slug is required' => ['slug', 'required'],
        'description is required' => ['description', 'required'],
    ]);

    it('can delete a service', function (): void {
        // Arrange
        $service = Service::factory()->create();

        // Act & Assert
        livewire(EditService::class, [
            'record' => $service->slug,
        ])
            ->callAction('delete')
            ->assertNotified()
            ->assertRedirect();

        // Verify soft delete
        expect($service->fresh()->trashed())->toBeTrue();
    });
});
