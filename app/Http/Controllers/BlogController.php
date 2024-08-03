<?php
namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\CategoryService;

class BlogController extends Controller{
    protected $postService;
    protected $categoryService;

    public function __construct(PostService $postService, CategoryService $categoryService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPublishedPosts(10);
        $posts->load('category');

        return view('blogs.index', compact('posts'));
    }
    
    public function show($slug)
    {
        $post = $this->postService->getPostBySlug($slug);
        $post->load('comments.author'); // Load comments relationship with user
        $post->load('category'); // Load category relationship  
        $post->load(['comments' => function ($query) { // Load comments relationship
            $query->orderBy('created_at', 'desc');
        }]);
        return view('blogs.show', compact('post'));
    }

    public function showCategory($id)
    {
        // Fetch the category by ID
        $category = $this->categoryService->getCategoryById($id);

        // Fetch posts associated with this category with pagination
        $posts = $this->postService->getPublishedPostsByCategory(10,$id);
        $posts->load('category');

        // Return a view with the category and posts data
        return view('blogs.category', compact('category', 'posts'));
    }
}
