<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Add this import


use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    // app/Models/Cart.php
    use HasFactory;

    // Add the fields you want to allow mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

public function user()
{
    return $this->belongsTo(User::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

}
