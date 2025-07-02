@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow p-5" style="width: 100%; max-width: 700px; border-radius: 1rem;">
        <h3 class="mb-4 text-center">
            <i class="bi bi-pencil-square me-2"></i> Create New Post
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

        <form id="create-post-form" action="{{ route('post.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control form-control-lg rounded-3" placeholder="Enter title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-4">
                <label for="body" class="form-label fw-semibold">Body</label>
                <textarea name="body" class="form-control rounded-3" rows="6" placeholder="Write your post here..." required>{{ old('body') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('post.index') }}" class="btn btn-outline-secondary">
                    ← Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    Publish
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $('#create-post-form').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                body: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Title must be at least 3 characters",
                    maxlength: "Title must not exceed 255 characters"
                },
                body: {
                    required: "Please enter the body of the post",
                    minlength: "Body must be at least 10 characters"
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
