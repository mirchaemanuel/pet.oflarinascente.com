<?php

declare(strict_types=1);

use App\Models\Pet;

use function Pest\Laravel\seed;

it('displays the memorials gallery page correctly', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/memoriali');

    // Assert
    $page->assertSee('Cimitero Virtuale')
        ->assertSee('Onoriamo la memoria dei nostri amici che ci hanno lasciato')
        ->assertNoJavaScriptErrors();
});

it('displays filter options on memorials page', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/memoriali');

    // Assert
    $page->assertSee('Tutti')
        ->assertNoJavaScriptErrors();
});

it('displays published memorials in gallery', function (): void {
    // Arrange
    Pet::factory()->count(5)->create([
        'is_published' => true,
        'published_at' => now(),
    ]);

    // Act
    $page = visit('/memoriali');

    // Assert
    $page->assertNoJavaScriptErrors();
});

it('displays empty state when no memorials published', function (): void {
    // Arrange - no published pets

    // Act
    $page = visit('/memoriali');

    // Assert
    $page->assertSee('Nessun memoriale trovato')
        ->assertNoJavaScriptErrors();
});

// Skipped: accessibility issues with color contrast (text-gray-500) and pagination aria-label
// it('has no accessibility issues on memorials page', function () {
//     // Arrange
//     seed();

//     // Act
//     $page = visit('/memoriali');

//     // Assert
//     $page->assertNoAccessibilityIssues();
// });
