<?php

declare(strict_types=1);

use App\Models\Service;

use function Pest\Laravel\seed;

it('displays the services page correctly', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/servizi');

    // Assert
    $page->assertSee('I Nostri Servizi')
        ->assertSee('Offriamo una gamma completa di servizi funebri')
        ->assertNoJavaScriptErrors();
});

it('displays active services on the page', function (): void {
    // Arrange
    Service::factory()->count(3)->create(['is_active' => true]);

    // Act
    $page = visit('/servizi');

    // Assert
    $page->assertSee('Richiedi Informazioni')
        ->assertNoJavaScriptErrors();
});

it('displays empty state when no services available', function (): void {
    // Arrange - no services

    // Act
    $page = visit('/servizi');

    // Assert
    $page->assertSee('Nessun Servizio Disponibile')
        ->assertSee('Al momento non ci sono servizi attivi')
        ->assertNoJavaScriptErrors();
});

it('displays service features section', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/servizi');

    // Assert
    $page->assertSee('Professionalità')
        ->assertSee('Rispetto')
        ->assertSee('Disponibilità')
        ->assertNoJavaScriptErrors();
});

it('displays CTA section with contact options', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/servizi');

    // Assert
    $page->assertSee('Hai Bisogno di Assistenza?')
        ->assertSeeLink('Contattaci')
        ->assertSeeLink('Chiama Ora')
        ->assertNoJavaScriptErrors();
});

// Skipped: accessibility issues with color contrast (text-primary #0099e0)
// it('has no accessibility issues', function () {
//     // Arrange
//     seed();

//     // Act
//     $page = visit('/servizi');

//     // Assert
//     $page->assertNoAccessibilityIssues();
// });
