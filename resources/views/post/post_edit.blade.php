@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow p-5" style="width: 100%; max-width: 700px; border-radius: 1rem;">
        <h3 class="mb-4 text-center">
            <i class="bi bi-pencil-square me-2"></i> Edit Post
        </h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('post.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT') 

            <div class="mb-4">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control form-control-lg rounded-3" placeholder="Enter title" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-4">
                <label for="body" class="form-label fw-semibold">Body</label>
                <textarea name="body" class="form-control rounded-3" rows="6" placeholder="Write your post here..." required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('post.my-posts') }}" class="btn btn-outline-secondary">
                    ← Cancel
                </a>
                <button type="submit" class="btn btn-success px-4">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
