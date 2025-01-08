<x-app-layout>
    <div class="container forum-post-detail">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $post->title }}</h3>
                            <small class="text-muted">
                                Posted by {{ $post->user->name }} 
                                on {{ $post->created_at->format('F d, Y') }}
                                @if($post->category)
                                | {{ $post->category }}
                                @endif
                            </small>
                        </div>
                        
                        @auth
                        @if(Auth::id() === $post->user_id)
                        <div>
                            <form action="{{ route('forum.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <p>{{ $post->content }}</p>
                        
                        <div class="post-actions mt-3">
                            <form action="{{ route('forum.like', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn {{ $post->isLikedBy(Auth::user()) ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-heart"></i> 
                                    {{ $post->likes_count }} Likes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="comments-section">
                    <h4>Comments ({{ $post->comments_count }})</h4>
                    
                    @foreach($post->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-1">
                                    {{ $comment->user->name }}
                                    <small class="text-muted ml-2">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </h6>
                            </div>
                            <p class="card-text">{{ $comment->content }}</p>
                        </div>
                    </div>
                    @endforeach

                    @auth
                    <div class="comment-form mt-4">
                        <form action="{{ route('forum.comment', $post->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea 
                                    class="form-control @error('content') is-invalid @enderror" 
                                    name="content" 
                                    rows="3" 
                                    placeholder="Add a comment..."
                                    required></textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Post Comment
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Please <a href="{{ route('login') }}">login</a> to post a comment.
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .forum-post-detail {
        background-color: #f8f9fa;
        padding: 20px;
    }
    .comments-section {
        margin-top: 20px;
    }
    </style>
    @endpush
</x-app-layout>
