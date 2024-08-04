<?php

use App\Http\Controllers\BlogController;
use App\Services\PostService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewInstance;
use Mockery\MockInterface;

beforeEach(function () {
    $this->postService = mock(PostService::class);
    $this->categoryService = mock(CategoryService::class);
    $this->controller = new BlogController($this->postService, $this->categoryService);
});

it('can list all published posts', function () {
    $posts = Mockery::mock('Illuminate\Database\Eloquent\Collection');
    $posts->shouldReceive('load')->with('category')->andReturnSelf();

    $this->postService->shouldReceive('getAllPublishedPosts')->with(10)->andReturn($posts);

    View::shouldReceive('make')->with('blogs.index', ['posts' => $posts])->andReturn(Mockery::mock(ViewInstance::class));

    $response = $this->controller->index();

    expect($response)->toBeInstanceOf(ViewInstance::class);
});

it('can show a single post', function () {
    $post = Mockery::mock('App\Models\Post');
    $post->shouldReceive('load')->with('comments.author')->andReturnSelf();
    $post->shouldReceive('load')->with('category')->andReturnSelf();
    $post->shouldReceive('load')->with(['comments' => Mockery::on(function ($query) {
        $query->orderBy('created_at', 'desc');
        return true;
    })])->andReturnSelf();

    $this->postService->shouldReceive('getPostBySlug')->with('test-slug')->andReturn($post);

    View::shouldReceive('make')->with('blogs.show', ['post' => $post])->andReturn(Mockery::mock(ViewInstance::class));

    $response = $this->controller->show('test-slug');

    expect($response)->toBeInstanceOf(ViewInstance::class);
});

it('can show posts by category', function () {
    $category = Mockery::mock('App\Models\Category');
    $posts = Mockery::mock('Illuminate\Database\Eloquent\Collection');
    $posts->shouldReceive('load')->with('category')->andReturnSelf();

    $this->categoryService->shouldReceive('getCategoryById')->with(1)->andReturn($category);
    $this->postService->shouldReceive('getPublishedPostsByCategory')->with(10, 1)->andReturn($posts);

    View::shouldReceive('make')->with('blogs.category', ['category' => $category, 'posts' => $posts])->andReturn(Mockery::mock(ViewInstance::class));

    $response = $this->controller->showCategory(1);

    expect($response)->toBeInstanceOf(ViewInstance::class);
});
