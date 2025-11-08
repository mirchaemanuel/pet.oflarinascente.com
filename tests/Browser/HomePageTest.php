<?php

declare(strict_types=1);

use function Pest\Laravel\seed;

it('displays the home page correctly', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertSee('Ama fino alla fine chi ti ha amato incondizionatamente')
        ->assertSee('Servizi funebri dedicati agli animali domestici')
        ->assertSee('Scopri i Nostri Servizi')
        ->assertSee('Visita i Memoriali')
        ->assertNoJavaScriptErrors();
});

it('displays services section on home page', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertSee('I Nostri Servizi')
        ->assertSee('Cremazione')
        ->assertSee('Sepoltura')
        ->assertSee('Cimitero Virtuale')
        ->assertNoJavaScriptErrors();
});

it('displays recent memorials section when pets exist', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertSee('Memoriali Recenti')
        ->assertSee('Vedi Tutti i Memoriali')
        ->assertNoJavaScriptErrors();
});

it('displays CTA section on home page', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertSee('Hai Bisogno di Assistenza?')
        ->assertSee('Contattaci')
        ->assertSee('Chiama Ora')
        ->assertNoJavaScriptErrors();
});

it('has working navigation links', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertSeeLink('Scopri i Nostri Servizi')
        ->assertSeeLink('Visita i Memoriali')
        ->assertSeeLink('Vedi Tutti i Memoriali')
        ->assertSeeLink('Contattaci')
        ->assertNoJavaScriptErrors();
});

it('displays home page without javascript errors', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/');

    // Assert
    $page->assertNoJavaScriptErrors();
});
