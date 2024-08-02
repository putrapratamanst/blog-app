<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup user authentication
    $this->user = \App\Models\User::factory()->create();
    actingAs($this->user);
    // Create some categories
    $this->categories = Category::factory()->count(5)->create();
});

it('can render the index page', function () {
    $response = get(route('posts.index'));

    $response->assertStatus(200);
});

it('can show a single post', function () {
    $post = Post::factory()->create();

    $response = get(route('posts.show', $post->id));

    $response->assertStatus(200);
    $response->assertSee($post->title);
});

it('can show the create post page', function () {
    $response = get(route('posts.create'));

    $response->assertStatus(200);
    $response->assertSee('Create Post');
});

it('can create a new post', function () {
    $category = $this->categories->first();
    $response = post(route('posts.store'), [
        'title' => 'Test Post',
        'meta_title' => 'Test Meta Title',
        'content' => 'Test Content',
        'image' => UploadedFile::fake()->image('test-image.jpg'),
        'status' => 'published',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post created successfully.');
    expect(Post::count())->toBe(1);
});

it('can show the edit post page', function () {
    $post = Post::factory()->create();

    $response = get(route('posts.edit', $post->id));

    $response->assertStatus(200);
    $response->assertSee('Edit Post');
});

it('can update an existing post', function () {
    $post = Post::factory()->create();
    $category = $this->categories->first();

    $response = put(route('posts.update', $post->id), [
        'title' => 'Updated Title',
        'meta_title' => 'Updated Meta Title',
        'content' => 'Updated Content',
        'status' => 'draft',
        'category_id' => $category->id,
        'tag' => 'Updated Tag',
    ]);

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post updated successfully');
    $post->refresh();
    expect($post->title)->toBe('Updated Title');
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    $response = delete(route('posts.destroy', $post->id));

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post deleted successfully');
    expect(Post::count())->toBe(0);
});
