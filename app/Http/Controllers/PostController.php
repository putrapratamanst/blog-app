<?php

namespace App\Http\Controllers;

use App\DataTables\PostDataTable;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('posts.index');
    }
    
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        // Handle image upload
        // $imagePath = $request->file('image')->store('uploads', 'public');
        try {
            $imagePath = $request->file('image')->store('uploads', 'public');
            // Handle the rest of your logic here (e.g., save the path to the database)
            return redirect()->back()->with('success', 'Image uploaded successfully!');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
        // Generate slug from title
        $slug = Str::slug($request->input('title'));

        if ($request['status'] == "published"){
            $request['published_at'] = Carbon::now();
        }

        $this->postService->createPost(
            [
                'title' => $request->input('title'),
                'slug' => $slug,
                'meta_title' => $request->input('meta_title'),
                'author' => Auth::id(),
                'content' => $request->input('content'),
                'image' => $imagePath,
                'status' => $request->input('status'),
                'category_id' => $request->input('category_id'),
                'published_at' => $request['published_at']
            ]
        );

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit($id)
    {
        $categories = Category::all(); // Get all categories
        $post = $this->postService->getPostById($id);
        return view('posts.edit', compact(['post','categories']));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'required|integer',
        ]);


        if ($request->hasFile('image')) {
            // $imagePath = $request->file('image')->store('uploads', 'public');
            try {
                $imagePath = $request->file('image')->store('uploads', 'public');
                // Handle the rest of your logic here (e.g., save the path to the database)
                return redirect()->back()->with('success', 'Image uploaded successfully!');
            } catch (Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
            $data['image'] = $imagePath;
        }

        die(json_encode($data));

        // Generate slug from title
        $slug = Str::slug($request->input('title'));

        $data['slug'] = $slug;
        if ($data['status'] == "published"){
            $data['published_at'] = Carbon::now();
        }
        $this->postService->updatePost($id, $data);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
