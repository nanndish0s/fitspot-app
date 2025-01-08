<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerService extends Model
{

    protected $fillable = ['trainer_id', 'service_name', 'description', 'price', 'image', 'location', 'latitude', 'longitude', 'location_address'];

    //
    public function trainer()
{
    return $this->belongsTo(Trainer::class);
}

}
