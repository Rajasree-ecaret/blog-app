<?php

namespace App\Repositories;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function store(array $data);

    public function findById(int $id);

    public function update(int $id, array $data);

    public function delete(int $id);
}
