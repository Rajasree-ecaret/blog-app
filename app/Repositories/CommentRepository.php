<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function store(array $data)
    {
        return Comment::create($data);
    }

    public function findById(int $id)
    {
        return Comment::with('post')->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $comment = Comment::findOrFail($id);
        return $comment->update($data);
    }

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);
        return $comment->delete();
    }
}
