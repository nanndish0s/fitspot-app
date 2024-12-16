<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
        'price',
        'trainer_id',
        'image'
    ];

    /**
     * Get the trainer that owns the service.
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
