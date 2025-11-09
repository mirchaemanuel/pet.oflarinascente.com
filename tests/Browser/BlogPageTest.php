<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\seed;

it('displays the blog index page correctly', function (): void {
    // Arrange
    seed();

    // Act
    $page = visit('/blog');

    // Assert
    $page->assertSee('Blog')
        ->assertSee('Consigli, storie e supporto')
        ->assertNoJavaScriptErrors();
});

it('displays published posts on blog index', function (): void {
    // Arrange
    $author = User::factory()->create();
    Post::factory()->count(3)->create([
        'author_id' => $author->id,
        'is_published' => true,
        'published_at' => now()->subDays(1),
    ]);

    // Act
    $page = visit('/blog');

    // Assert
    $page->assertSee('Continua a leggere')
        ->assertNoJavaScriptErrors();
});

it('displays empty state when no posts available', function (): void {
    // Arrange - no posts

    // Act
    $page = visit('/blog');

    // Assert
    $page->assertSee('Nessun Articolo Disponibile')
        ->assertNoJavaScriptErrors();
});

it('displays post detail page correctly', function (): void {
    // Arrange
    $author = User::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $author->id,
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    // Act
    $page = visit('/blog/'.$post->slug);

    // Assert
    $page->assertSee($post->title)
        ->assertSee('Torna al Blog')
        ->assertNoJavaScriptErrors();
});

it('has social sharing buttons on post detail', function (): void {
    // Arrange
    $author = User::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $author->id,
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    // Act
    $page = visit('/blog/'.$post->slug);

    // Assert
    $page->assertSee('Condividi:')
        ->assertNoJavaScriptErrors();
});
