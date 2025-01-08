<x-app-layout>
    <div class="container forum-page">
        <h1 class="mb-4">Community Forum</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        Forum Categories
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Fitness Tips</li>
                        <li class="list-group-item">Nutrition</li>
                        <li class="list-group-item">Workout Routines</li>
                        <li class="list-group-item">General Discussion</li>
                    </ul>
                </div>
                
                <a href="{{ route('forum.create') }}" class="btn btn-primary btn-block mb-3">
                    Create New Post
                </a>
            </div>

            <div class="col-md-9">
                @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    <a href="{{ route('forum.show', $post->id) }}">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    By {{ $post->user->name }} 
                                    | {{ $post->created_at->diffForHumans() }}
                                    @if($post->category)
                                    | {{ $post->category }}
                                    @endif
                                </h6>
                            </div>
                            
                            @auth
                            @if(Auth::id() === $post->user_id)
                            <div>
                                <form action="{{ route('forum.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                            @endauth
                        </div>

                        <p class="card-text">
                            {{ Str::limit($post->content, 200) }}
                        </p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="mr-3">
                                    <i class="fas fa-comment"></i> 
                                    {{ $post->comments_count }} Comments
                                </span>
                                <span>
                                    <i class="fas fa-heart"></i> 
                                    {{ $post->likes->count() }} Likes
                                </span>
                            </div>
                            <a href="{{ route('forum.show', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .forum-page {
        background-color: #f8f9fa;
        padding: 20px;
    }
    </style>
    @endpush
</x-app-layout>
