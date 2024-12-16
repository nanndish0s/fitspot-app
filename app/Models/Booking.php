<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'trainer_id',
        'service_id',
        'session_date',
        'notes',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function service()
    {
        return $this->belongsTo(TrainerService::class);
    }
}
