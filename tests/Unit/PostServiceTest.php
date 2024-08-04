<?php

use App\Models\Post;
use App\Services\PostService;

beforeEach(function () {
    $this->post = mock(Post::class);
    $this->postService = new PostService($this->post);
});

it('can get all posts', function () {
    $posts = collect(['post1', 'post2']);
    $this->post->shouldReceive('all')->once()->andReturn($posts);

    $result = $this->postService->getAllPosts();

    expect($result)->toBe($posts);
});

it('can get all published posts', function () {
    $perPage = 10;
    $publishedPosts = 'paginated result';
    $this->post->shouldReceive('where')->with('status', 'published')->andReturnSelf();
    $this->post->shouldReceive('orderBy')->with('published_at', 'desc')->andReturnSelf();
    $this->post->shouldReceive('paginate')->with($perPage)->andReturn($publishedPosts);

    $result = $this->postService->getAllPublishedPosts($perPage);

    expect($result)->toBe($publishedPosts);
});

it('can get published posts by category', function () {
    $perPage = 10;
    $categoryID = 1;
    $publishedPosts = 'paginated result';
    $this->post->shouldReceive('where')->with('status', 'published')->andReturnSelf();
    $this->post->shouldReceive('where')->with('category_id', $categoryID)->andReturnSelf();
    $this->post->shouldReceive('orderBy')->with('published_at', 'desc')->andReturnSelf();
    $this->post->shouldReceive('paginate')->with($perPage)->andReturn($publishedPosts);

    $result = $this->postService->getPublishedPostsByCategory($perPage, $categoryID);

    expect($result)->toBe($publishedPosts);
});

it('can get post by ID', function () {
    $id = 1;
    $post = new stdClass();
    $this->post->shouldReceive('findOrFail')->with($id)->andReturn($post);

    $result = $this->postService->getPostById($id);

    expect($result)->toBe($post);
});

it('can get post by slug', function () {
    $slug = 'test-slug';
    $post = new stdClass();
    $this->post->shouldReceive('where')->with('slug', $slug)->andReturnSelf();
    $this->post->shouldReceive('firstOrFail')->andReturn($post);

    $result = $this->postService->getPostBySlug($slug);

    expect($result)->toBe($post);
});

it('can create a post', function () {
    $data = ['title' => 'Test Post', 'content' => 'This is a test post'];
    $post = new stdClass();
    $this->post->shouldReceive('create')->with($data)->andReturn($post);

    $result = $this->postService->createPost($data);

    expect($result)->toBe($post);
});

it('can update a post', function () {
    $id = 1;
    $data = ['title' => 'Updated Post', 'content' => 'This is an updated post'];
    $post = mock(Post::class);
    $this->post->shouldReceive('findOrFail')->with($id)->andReturn($post);
    $post->shouldReceive('update')->with($data)->andReturn(true);

    $result = $this->postService->updatePost($id, $data);

    expect($result)->toBe($post);
});
it('can delete a post', function () {
    $id = 1;
    $post = Mockery::mock(Post::class);
    $this->post->shouldReceive('findOrFail')->with($id)->andReturn($post);
    $post->shouldReceive('delete')->andReturn(true);

    $this->postService->deletePost($id);

    $post->shouldHaveReceived('delete');
});


afterEach(function () {
    Mockery::close();
});
