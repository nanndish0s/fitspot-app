<x-app-layout>
    <div class="container create-post-page">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Forum Post</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('forum.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="title">Post Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}"
                                       required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Fitness Tips">Fitness Tips</option>
                                    <option value="Nutrition">Nutrition</option>
                                    <option value="Workout Routines">Workout Routines</option>
                                    <option value="General Discussion">General Discussion</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="content">Post Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" 
                                          name="content" 
                                          rows="5" 
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Create Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .create-post-page {
        background-color: #f8f9fa;
        padding: 20px;
    }
    </style>
    @endpush
</x-app-layout>
