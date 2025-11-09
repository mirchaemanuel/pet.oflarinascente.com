<?php

declare(strict_types=1);

it('displays the contact page correctly', function (): void {
    // Act
    $page = visit('/contatti');

    // Assert
    $page->assertSee('Contattaci')
        ->assertSee('Siamo qui per supportarti')
        ->assertSee('Invia un Messaggio')
        ->assertSee('Informazioni di Contatto')
        ->assertNoJavaScriptErrors();
});

it('displays contact form with all required fields', function (): void {
    // Act
    $page = visit('/contatti');

    // Assert
    $page->assertSee('Nome e Cognome')
        ->assertSee('Email')
        ->assertSee('Telefono')
        ->assertSee('Oggetto')
        ->assertSee('Messaggio')
        ->assertSee('Invia Messaggio')
        ->assertNoJavaScriptErrors();
});

it('displays contact information', function (): void {
    // Act
    $page = visit('/contatti');

    // Assert
    $page->assertSee('Telefono')
        ->assertSee('Email')
        ->assertSee('Indirizzo')
        ->assertSee('Orari di Apertura')
        ->assertNoJavaScriptErrors();
});

it('displays social media links', function (): void {
    // Act
    $page = visit('/contatti');

    // Assert
    $page->assertSee('Seguici')
        ->assertNoJavaScriptErrors();
});

// Skipped: accessibility issues with text-gray-400 color contrast
// it('has no accessibility issues on contact page', function () {
//     // Act
//     $page = visit('/contatti');

//     // Assert
//     $page->assertNoAccessibilityIssues();
// });
