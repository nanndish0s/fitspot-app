<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition duration-300 group">
                <svg class="w-5 h-5 mr-2 text-indigo-500 group-hover:-translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Forum
            </a>
            <div class="flex items-center space-x-3">
                @if($post->category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ $post->category }}
                    </span>
                @endif
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    Forum Post Details
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Post Section --}}
            <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $post->title }}
                            </h1>
                            <div class="text-sm text-gray-600 flex items-center space-x-3">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $post->user->name }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $post->created_at->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        @auth
                        @if(Auth::id() === $post->user_id)
                        <div>
                            <form action="{{ route('forum.destroy', $post->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 group">
                                    <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Post
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>

                    <div class="prose prose-indigo max-w-none text-gray-800 mb-6">
                        {{ $post->content }}
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <form action="{{ route('forum.like', $post->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 
                                           {{ Auth::check() && $post->isLikedBy(Auth::user()) 
                                              ? 'bg-red-500 text-white' 
                                              : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} 
                                           rounded-lg transition duration-300 group">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition" 
                                     fill="{{ Auth::check() && $post->isLikedBy(Auth::user()) ? 'currentColor' : 'none' }}" 
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ $post->likes_count }} Likes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Comments Section --}}
            <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Comments ({{ $post->comments_count }})
                    </h2>

                    @if($post->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($post->comments as $comment)
                                <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h6 class="font-semibold text-gray-800">
                                                {{ $comment->user->name }}
                                            </h6>
                                            <span class="text-xs text-gray-500">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">
                                        {{ $comment->content }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-6">
                            No comments yet. Be the first to comment!
                        </div>
                    @endif

                    @auth
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <form action="{{ route('forum.comment', $post->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="comment" class="sr-only">Add a comment</label>
                                    <textarea 
                                        id="comment"
                                        name="content" 
                                        rows="4" 
                                        class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm resize-y @error('content') border-red-500 @enderror"
                                        placeholder="Add a comment..."
                                        required></textarea>
                                    @error('content')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 space-x-2 group">
                                        <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-8 border-t border-gray-200 pt-6 text-center">
                            <p class="text-gray-600">
                                Please <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">login</a> to post a comment.
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>FitSpot</h5>
                <p>Your ultimate destination for fitness and wellness.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('services.index') }}" class="text-white-50">Services</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Connect With Us</h5>
                <div class="social-links">
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-white">
        <div class="text-center">
            <p>&copy; 2024 FitSpot. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
