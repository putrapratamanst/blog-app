<?php
namespace App\Services;

use App\Models\Post;

class PostService
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAllPosts()
    {
        return $this->post->all();
    }

    public function getAllPublishedPosts()
    {
        return $this->post->all()->where('status',"==", "published");
    }

    public function getPostById($id)
    {
        return $this->post->findOrFail($id);
    }

    public function createPost(array $data)
    {
        return $this->post->create($data);
    }

    public function updatePost($id, array $data)
    {
        $post = $this->post->findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function deletePost($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();
    }
}
