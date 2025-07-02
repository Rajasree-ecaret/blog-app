<?php

namespace App\Repositories;

use App\Models\Post;


interface PostRepositoryInterface
{
    public function all() ;
    public function create(array $data);
    public function findById(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getUserPosts(int $userId);
}
