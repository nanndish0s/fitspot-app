<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    // Define which attributes can be mass-assigned
    protected $fillable = [
        'user_id', 'specialization', 'bio', 'profile_picture'
    ];

    /**
     * Get the user that owns the trainer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services provided by the trainer.
     */
    public function services()
    {
        return $this->hasMany(TrainerService::class);
    }

    /**
     * Get the bookings associated with the trainer.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
