<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id || 
               $user->id === $booking->trainer->user_id;
    }

    public function cancel(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id;
    }
}
