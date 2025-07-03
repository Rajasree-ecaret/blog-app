<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'abc@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        Post::firstOrCreate(
            ['title' => 'abc'],
            [
                'body' => 'ydgusdfdsfd',
                'user_id' => $user->id,
            ]
        );
    }
}
