<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreCommentRequest $request)
{
    // dd($request->post_id);
    $request->validate([
        'body' => 'required',
        'post_id' => 'required',
    ]);

    $post = Post::findOrFail($request->post_id);

    $post->comments()->create([
        'user_id' => Auth::user()->id,
        'body' => $request->body,
    ]);

    return redirect()->route('post.show', $post->id)->with('success', 'Comment added!');
}


    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
     $comment = Comment::with('post')->findOrFail($id);
    return view('comment.comment_edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(UpdateCommentRequest $request, $id)
{
    $comment = Comment::findOrFail($id);
    $comment->update($request->validated());

    return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment updated!');
}

public function destroy( $id)
{
    $comment = Comment::findOrFail($id);
    $comment->delete();

    return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment deleted!');
}
}
