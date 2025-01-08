<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumPostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Display all forum posts
    public function index()
    {
        $posts = ForumPost::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('forum.index', compact('posts'));
    }

    // Show form to create a new post
    public function create()
    {
        return view('forum.create');
    }

    // Store a new forum post
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'nullable|string'
        ]);

        $post = new ForumPost();
        $post->user_id = Auth::id();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->category = $validatedData['category'] ?? null;
        $post->save();

        return redirect()->route('forum.show', $post->id)
            ->with('success', 'Post created successfully');
    }

    // Show a specific forum post
    public function show($id)
    {
        $post = ForumPost::with(['user', 'comments.user'])->findOrFail($id);
        return view('forum.show', compact('post'));
    }

    // Add a comment to a post
    public function addComment(Request $request, $postId)
    {
        $validatedData = $request->validate([
            'content' => 'required|string'
        ]);

        $comment = new ForumComment();
        $comment->forum_post_id = $postId;
        $comment->user_id = Auth::id();
        $comment->content = $validatedData['content'];
        $comment->save();

        // Update comments count on the post
        $post = ForumPost::find($postId);
        $post->increment('comments_count');

        return back()->with('success', 'Comment added successfully');
    }

    // Like or unlike a post
    public function toggleLike($postId)
    {
        $post = ForumPost::findOrFail($postId);
        $user = Auth::user();

        $existingLike = ForumPostLike::where('forum_post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Unlike the post
            $existingLike->delete();
            $message = 'Post unliked successfully';
        } else {
            // Like the post
            ForumPostLike::create([
                'forum_post_id' => $post->id,
                'user_id' => $user->id
            ]);
            $message = 'Post liked successfully';
        }

        // Update likes count
        $likesCount = ForumPostLike::where('forum_post_id', $post->id)->count();
        $post->update(['likes_count' => $likesCount]);

        return back()->with('success', $message);
    }

    // Delete a forum post
    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);

        // Ensure only the post owner can delete
        if (Auth::id() !== $post->user_id) {
            return back()->with('error', 'You are not authorized to delete this post.');
        }

        // Delete associated comments first
        ForumComment::where('forum_post_id', $post->id)->delete();

        // Delete the post
        $post->delete();

        return redirect()->route('forum.index')
            ->with('success', 'Post deleted successfully');
    }
}
