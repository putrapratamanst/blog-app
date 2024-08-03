<?php
namespace App\Services;

use App\Models\Comment;

class CommentService 
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function createComment(array $data)
    {
        return $this->comment->create($data);
    }

}