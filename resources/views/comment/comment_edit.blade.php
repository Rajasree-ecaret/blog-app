@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h5>Edit Comment</h5>

                <form action="{{ route('comment.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <textarea name="body" class="form-control" rows="3" required>{{ old('body', $comment->body) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('post.show', $comment->post_id) }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
