<?php
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->postService = mock(PostService::class);
});

it('can display a list of posts', function () {
    $posts = Post::factory()->count(3)->create();
    
    // Simulasi metode `getAllPosts` pada PostService
    $this->postService->shouldReceive('getAllPosts')
        ->andReturn($posts);

    // Test route /posts
    get('/posts')
        ->assertStatus(200)
        ->assertViewHas('posts', $posts);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    // Simulasi metode `deletePost` pada PostService
    $this->postService->shouldReceive('deletePost')
        ->with($post->id)
        ->once();

    // Test route /posts/{id}
    delete('/posts/' . $post->id)
        ->assertRedirect('/posts')
        ->assertSessionHas('success', 'Post deleted successfully');
});
