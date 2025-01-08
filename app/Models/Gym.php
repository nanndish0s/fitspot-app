<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'description',
        'opening_hours',
        'amenities',
    ];

    protected $casts = [
        'amenities' => 'array',
        'opening_hours' => 'array',
    ];
}
