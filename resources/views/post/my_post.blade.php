@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Posts</h2>

    @if ($posts->count())
        @foreach ($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $post->title }}</h5>
                    <p class="text-muted small mb-2">
                        {{ $post->created_at->format('M d, Y') }}
                    </p>
                    <p class="card-text">{{ Str::limit($post->body, 100) }}</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary btn-sm">
                            View Details →
                        </a>

                        <div>
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning me-2">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            You haven't created any posts yet.
        </div>
    @endif
</div>
@endsection
