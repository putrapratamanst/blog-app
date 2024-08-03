<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;
    protected $postService;

    public function __construct(CommentService $commentService, PostService $postService)
    {
        $this->commentService = $commentService;
        $this->postService = $postService;

    }

    public function store(Request $request){
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $this->commentService->createComment([
            'comment' => $request->input('comment'),
            'author_id'=>Auth::id(),
            'post_id'=>$request->input('post_id')
        ]);

        return redirect()->route('blogs.show', ['blog' => $request->input('slug')])
        ->with('success', 'Comment created successfully')
        ->header('Location', url()->route('blogs.show', ['blog' => $request->input('slug')]) . '#comments-section');
    }
}
