<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'likes_count',
        'comments_count'
    ];

    // Relationship with user who created the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with comments
    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }

    // Relationship with likes
    public function likes()
    {
        return $this->hasMany(ForumPostLike::class);
    }

    // Check if a user has liked the post
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
