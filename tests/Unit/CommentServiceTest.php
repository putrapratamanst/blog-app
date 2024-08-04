<?php

use App\Models\Comment;
use App\Services\CommentService;

beforeEach(function () {
    $this->comment = mock(Comment::class);
    $this->commentService = new CommentService($this->comment);
});

it('can create a comment', function () {
    $data = [
        'comment' => 'This is a test comment',
        'author_id' => 1,
        'post_id' => 1,
    ];

    // Mocking the create method
    $this->comment->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

    $result = $this->commentService->createComment($data);

    expect($result)->toEqual((object) $data);
});

afterEach(function () {
    Mockery::close();
});
