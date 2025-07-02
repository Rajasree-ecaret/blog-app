<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::all();
        return view('post.post_index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.post_create');
    }

    public function myPosts()
    {
    $posts = Post::where('user_id', Auth::user()->id)->latest()->get();
    return view('post.my_post', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
    ]);

    Post::create([
        'user_id' => Auth::user()->id,
        'title' => $request->title,
        'body' => $request->body,
    ]);
    return redirect()->route('post.index')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
    return view('post.post_show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('post.post_edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
         Post::findOrFail($id)->update($request->validated());
        return redirect()->route('post.my-posts')->with('success','updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('post.my-posts')->with('success','deleted!');
    }
}
