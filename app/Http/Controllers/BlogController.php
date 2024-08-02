<?php
namespace App\Http\Controllers;

use App\DataTables\PostDataTable;
use App\Services\PostService;

class BlogController extends Controller{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPublishedPosts(3);

        return view('blogs.index', compact('posts'));
    }
    

}
