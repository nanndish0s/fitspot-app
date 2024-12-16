<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor for formatted created date
    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
