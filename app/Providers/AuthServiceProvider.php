<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('view-booking', function (User $user, Booking $booking) {
            // User can view their own bookings
            if ($user->id === $booking->user_id) {
                return true;
            }
            
            // Trainer can view bookings assigned to them
            if ($user->role === 'trainer' && $user->trainer && $user->trainer->id === $booking->trainer_id) {
                return true;
            }
            
            return false;
        });

        Gate::define('cancel-booking', function (User $user, Booking $booking) {
            // Only the booking owner can cancel their booking
            if ($user->id !== $booking->user_id) {
                return false;
            }

            // Can only cancel pending or confirmed bookings
            return in_array($booking->status, ['pending', 'confirmed']);
        });
    }
}
