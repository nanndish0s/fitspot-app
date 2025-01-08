<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_post_id',
        'user_id',
        'content',
        'likes_count'
    ];

    // Relationship with the post
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    // Relationship with user who created the comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
