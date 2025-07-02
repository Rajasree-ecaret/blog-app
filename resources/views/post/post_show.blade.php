@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Left Side: Post + Add Comment --}}
        <div class="col-md-6">
            {{-- Post Display --}}
            <div class="card shadow p-4 rounded mb-4">
                <h3 class="mb-2">{{ $post->title }}</h3>
                <p class="text-muted small mb-3">
                    By <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->format('M d, Y') }}
                </p>
                <hr>
                <div class="fs-5">{!! nl2br(e($post->body)) !!}</div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Comment Form --}}
            <div class="card shadow-sm p-4 rounded mb-4">
                <h5>Add a Comment</h5>
                @auth
                    <form id="comment-form" action="{{ route('comment.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="mb-3">
                            <textarea name="body" class="form-control" rows="3" placeholder="Write your comment..." required>{{ old('body') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                        <a href="{{ route('post.index') }}" class="btn btn-dark btn-secondary">← Back to All Posts</a>
                    </form>
                @else
                    <div class="alert alert-info mt-3">
                        <a href="{{ route('login') }}">Log in</a> to post a comment.
                    </div>
                @endauth
            </div>
        </div>

        {{-- Right Side: All Comments --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4 rounded">
                <h5 class="mb-3">{{ $post->comments->count() }} Comment(s)</h5>
                @if ($post->comments->count())
                    <ul class="list-group list-group-flush">
                        @foreach ($post->comments as $comment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    @if(auth()->check() && auth()->id() === $comment->user_id)
                                        <span class="fw-bold text-success">{{ $comment->user->name }}- you</span>:
                                    @else
                                        <span class="fw-bold">{{ $comment->user->name }}</span>:
                                    @endif
                                    <br>
                                    <span class="text-truncate d-inline-block" style="max-width: 300px;">
                                        {{ $comment->body }}
                                    </span>

                                    <span class="text-muted small ms-2">• {{ $comment->created_at->diffForHumans() }}</span>
                                </div>

                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        <div class="btn-group">
                                            <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-secondary">No comments yet.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $('#comment-form').validate({
            rules: {
                body: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                body: {
                    required: "Please write a comment.",
                    minlength: "Comment must be at least 3 characters."
                }
            },
            errorElement: 'div',
            errorClass: 'text-danger small mt-1',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
