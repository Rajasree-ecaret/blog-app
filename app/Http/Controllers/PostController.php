<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->all();
        return view('post.post_index', compact('posts'));
    }

    public function create()
    {
        return view('post.post_create');
    }

    public function myPosts()
    {
        $posts = $this->postRepository->getUserPosts(Auth::id());
        return view('post.my_post', compact('posts'));
    }

    public function store(StorePostRequest $request)
    {
        $data = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ];

        $this->postRepository->create($data);
        return redirect()->route('post.index')->with('success', 'Post Created');
    }

    public function show($id)
    {
        $post = $this->postRepository->findById($id);
        return view('post.post_show', compact('post'));
    }

    public function edit($id)
    {
        $post = $this->postRepository->findById($id);
        return view('post.post_edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $this->postRepository->update($id, $request->validated());
        return redirect()->route('post.my-posts')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return redirect()->route('post.my-posts')->with('success', 'Deleted!');
    }
}