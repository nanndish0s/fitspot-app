<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TrainerService;
use App\Models\Product;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(TrainerService::class, 'service_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Scope to find existing wishlist item
    public function scopeFindExistingItem($query, $userId, $serviceId = null, $productId = null)
    {
        return $query->where('user_id', $userId)
            ->where(function($q) use ($serviceId, $productId) {
                if ($serviceId) {
                    $q->where('service_id', $serviceId);
                }
                if ($productId) {
                    $q->orWhere('product_id', $productId);
                }
            });
    }
}
