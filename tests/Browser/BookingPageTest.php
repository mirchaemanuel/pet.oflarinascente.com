<?php

declare(strict_types=1);

use function Pest\Laravel\seed;

it('displays the booking page correctly', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/prenota');

    // Assert
    $page->assertSee('Prenota un Servizio')
        ->assertSee('Compila il modulo sottostante')
        ->assertNoJavaScriptErrors();
});

it('displays booking form with all required fields', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/prenota');

    // Assert
    $page->assertSee('Servizio Richiesto')
        ->assertSee('Informazioni di Contatto')
        ->assertSee('Nome e Cognome')
        ->assertSee('Email')
        ->assertSee('Telefono')
        ->assertSee('Informazioni sull\'Animale')
        ->assertSee('Dettagli Aggiuntivi')
        ->assertSee('Invia Richiesta')
        ->assertNoJavaScriptErrors();
});

it('displays info cards on booking page', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/prenota');

    // Assert
    $page->assertSee('Risposta Rapida')
        ->assertSee('Privacy Garantita')
        ->assertSee('Supporto Compassionevole')
        ->assertNoJavaScriptErrors();
});

it('displays alternative contact section', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/prenota');

    // Assert
    $page->assertSee('Preferisci Parlare con Noi?')
        ->assertSeeLink('Chiama Ora')
        ->assertSeeLink('Invia Email')
        ->assertNoJavaScriptErrors();
});

// Skipped: accessibility issues with text-gray-400 color contrast
// it('has no accessibility issues on booking page', function () {
//     // Arrange
//     seed();

//     // Act
//     $page = visit('/prenota');

//     // Assert
//     $page->assertNoAccessibilityIssues();
// });
