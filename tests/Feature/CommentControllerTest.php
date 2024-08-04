<?php

use App\Http\Controllers\CommentController;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\MockInterface;

beforeEach(function () {
    $this->commentService = mock(CommentService::class);
    $this->postService = mock(PostService::class);
    $this->controller = new CommentController($this->commentService, $this->postService);
});

it('can store a comment', function () {
    // Mocking the request
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('validate')->once()->with([
        'comment' => 'required|string|max:255',
    ])->andReturnSelf();
    $request->shouldReceive('input')->with('comment')->andReturn('This is a test comment');
    $request->shouldReceive('input')->with('post_id')->andReturn(1);
    $request->shouldReceive('input')->with('slug')->andReturn('test-slug');

    // Mocking the Auth facade
    Auth::shouldReceive('id')->andReturn(1);

    // Mocking the CommentService
    $this->commentService->shouldReceive('createComment')->once()->with([
        'comment' => 'This is a test comment',
        'author_id' => 1,
        'post_id' => 1,
    ])->andReturn(true);

    // Mocking the redirect
    Redirect::shouldReceive('route')
        ->with('blogs.show', ['blog' => 'test-slug'])
        ->andReturnSelf();
    Redirect::shouldReceive('with')
        ->with('success', 'Comment created successfully')
        ->andReturnSelf();
    Redirect::shouldReceive('header')
        ->with('Location', url()->route('blogs.show', ['blog' => 'test-slug']) . '#comments-section')
        ->andReturnSelf();

    // Calling the controller method
    $response = $this->controller->store($request);

    // Assertions
    expect($response)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);
});
