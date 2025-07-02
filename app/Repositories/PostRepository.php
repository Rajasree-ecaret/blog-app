<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::all();
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function findById(int $id)
    {
        return Post::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $post = Post::findOrFail($id);
        return $post->update($data);
    }

    public function delete(int $id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }

    public function getUserPosts(int $userId)
    {
        return Post::where('user_id', $userId)->latest()->get();
    }
}
