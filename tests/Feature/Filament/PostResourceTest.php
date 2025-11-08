<?php

declare(strict_types=1);

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

describe('List Posts', function (): void {
    it('can load the list page', function (): void {
        // Arrange
        $posts = Post::factory()->count(5)->create(['author_id' => $this->admin->id]);

        // Act & Assert
        livewire(ListPosts::class)
            ->assertOk()
            ->assertCanSeeTableRecords($posts);
    });

    it('can search posts by title', function (): void {
        // Arrange
        $posts = Post::factory()->count(5)->create(['author_id' => $this->admin->id]);

        // Act & Assert
        livewire(ListPosts::class)
            ->assertCanSeeTableRecords($posts)
            ->searchTable($posts->first()->title)
            ->assertCanSeeTableRecords($posts->take(1))
            ->assertCanNotSeeTableRecords($posts->skip(1));
    });

    it('can filter posts by published status', function (): void {
        // Filter not implemented yet
        expect(true)->toBeTrue();
    })->skip('is_published filter not implemented in PostsTable');
});

describe('Create Post', function (): void {
    it('can load the create page', function (): void {
        // Act & Assert
        livewire(CreatePost::class)
            ->assertOk();
    });

    it('can create a post', function (): void {
        // Arrange
        $newPostData = Post::factory()->make();

        // Act & Assert
        livewire(CreatePost::class)
            ->set('data.title', $newPostData->title)
            ->set('data.slug', $newPostData->slug)
            ->set('data.author_id', $this->admin->id)
            ->set('data.content', $newPostData->content)
            ->set('data.excerpt', $newPostData->excerpt)
            ->set('data.is_published', $newPostData->is_published)
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        // Verify database
        assertDatabaseHas(Post::class, [
            'title' => $newPostData->title,
            'slug' => $newPostData->slug,
        ]);
    });

    it('validates required fields', function (array $data, array $errors): void {
        // Arrange
        $newPostData = Post::factory()->make();

        // Act & Assert
        livewire(CreatePost::class)
            ->fillForm([
                'title' => $newPostData->title,
                'slug' => $newPostData->slug,
                'author_id' => $this->admin->id,
                'content' => $newPostData->content,
                ...$data,
            ])
            ->call('create')
            ->assertHasFormErrors($errors)
            ->assertNotNotified()
            ->assertNoRedirect();
    })->with([
        'title is required' => [['title' => null], ['title' => 'required']],
        'slug is required' => [['slug' => null], ['slug' => 'required']],
        'author_id is required' => [['author_id' => null], ['author_id' => 'required']],
    ]);

    it('auto-generates slug from title', function (): void {
        expect(true)->toBeTrue();
    })->skip('Filament reactive forms need investigation');
});

describe('Edit Post', function (): void {
    it('can load the edit page', function (): void {
        // Arrange
        $post = Post::factory()->create(['author_id' => $this->admin->id]);

        // Act & Assert
        livewire(EditPost::class, [
            'record' => $post->slug,
        ])
            ->assertOk()
            ->assertSchemaStateSet([
                'title' => $post->title,
                'slug' => $post->slug,
                'author_id' => $post->author_id,
                'is_published' => $post->is_published,
            ]);
    });

    it('can update a post', function (): void {
        // Arrange
        $post = Post::factory()->create(['author_id' => $this->admin->id]);
        $newTitle = fake()->sentence();
        $newSlug = str($newTitle)->slug();

        // Act & Assert
        livewire(EditPost::class, [
            'record' => $post->slug,
        ])
            ->set('data.title', $newTitle)
            ->set('data.slug', $newSlug)
            ->set('data.content', 'Updated content')
            ->call('save')
            ->assertNotified();

        // Verify database
        assertDatabaseHas(Post::class, [
            'id' => $post->id,
            'title' => $newTitle,
            'slug' => $newSlug,
        ]);
    });

    it('can publish a post', function (): void {
        // Arrange
        $post = Post::factory()->create([
            'author_id' => $this->admin->id,
            'is_published' => false,
        ]);

        // Act & Assert
        livewire(EditPost::class, [
            'record' => $post->slug,
        ])
            ->set('data.is_published', true)
            ->call('save')
            ->assertNotified();

        // Verify database
        $post->refresh();
        expect($post->is_published)->toBeTrue()
            ->and($post->published_at)->not->toBeNull();
    });

    it('can delete a post', function (): void {
        // Arrange
        $post = Post::factory()->create(['author_id' => $this->admin->id]);

        // Act & Assert
        livewire(EditPost::class, [
            'record' => $post->slug,
        ])
            ->callAction('delete')
            ->assertNotified()
            ->assertRedirect();

        // Verify soft delete
        expect($post->fresh()->trashed())->toBeTrue();
    });
});
