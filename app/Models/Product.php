<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'quantity', 'image', 'user_id',
    ];

    /**
     * A product belongs to a user (seller).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest(); // Order reviews by most recent first
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewsCount()
    {
        return $this->reviews()->count();
    }
}
