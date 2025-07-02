@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📃 All Posts</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($posts as $post)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-3">
                        <h6 class="card-title text-primary mb-1">{{ $post->title }}</h6>
                        <small class="text-muted d-block mb-2">
                            {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                        </small>
                        <p class="card-text small">{{ Str::limit($post->body, 80) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-3 pb-3">
                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-primary w-100">
                            View Comments →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>
</div>
@endsection
