<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use App\Repositories\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
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
        $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'body' => $request->body,
        ];

        $this->commentRepository->store($data);

        return redirect()->route('post.show', $request->post_id)->with('success', 'Comment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
        $comment = $this->commentRepository->findById($id);
        return view('comment.comment_edit', compact('comment'));
    }


    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateCommentRequest $request, $id)
    {
        $this->commentRepository->update($id, $request->validated());
        $comment = $this->commentRepository->findById($id);
        return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment updated!');
    }

    public function destroy($id)
    {
        $comment = $this->commentRepository->findById($id);
        $this->commentRepository->delete($id);

        return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment deleted!');
    }
}
