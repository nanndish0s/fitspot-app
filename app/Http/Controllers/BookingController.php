<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TrainerService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\CardException;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->with(['trainer.user', 'service'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create($service_id)
    {
        $service = TrainerService::with('trainer.user')->findOrFail($service_id);
        
        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $service->price * 100, // Amount in cents
                'currency' => 'usd', // Changed to USD which is widely supported
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return view('bookings.create', [
                'service' => $service,
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment intent creation failed: ' . $e->getMessage());
            return back()->with('error', 'Unable to initialize payment. Please try again.');
        }
    }

    public function store(Request $request)
    {
        \Log::info('Storing booking details in session', $request->all());
        
        // Validate the request
        $validated = $request->validate([
            'service_id' => 'required|exists:trainer_services,id',
            'session_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check for existing bookings
        $existingBooking = Booking::where('trainer_id', TrainerService::findOrFail($validated['service_id'])->trainer_id)
            ->where('service_id', $validated['service_id'])
            ->where('session_date', $validated['session_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return response()->json([
                'status' => 'error', 
                'message' => 'This time slot is already booked. Please choose a different time.'
            ], 422);
        }

        // Store booking details in session
        session([
            'booking_service_id' => $validated['service_id'],
            'booking_session_date' => $validated['session_date'],
            'booking_notes' => $validated['notes'],
        ]);

        return response()->json(['status' => 'success']);
    }

    public function handlePaymentComplete(Request $request)
    {
        \Log::info('Payment completion callback received', ['query' => $request->all()]);
        
        try {
            // Get the payment intent ID from the query parameters
            $payment_intent = $request->query('payment_intent');
            if (!$payment_intent) {
                throw new \Exception('No payment intent ID provided');
            }

            \Log::info('Retrieving payment intent', ['id' => $payment_intent]);

            // Set up Stripe client
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            // Get payment intent details from Stripe
            $intent = $stripe->paymentIntents->retrieve($payment_intent);
            
            \Log::info('Payment intent retrieved', [
                'status' => $intent->status,
                'amount' => $intent->amount,
                'currency' => $intent->currency
            ]);
            
            if ($intent->status !== 'succeeded') {
                throw new \Exception('Payment was not successful. Status: ' . $intent->status);
            }

            // Get the service ID from session
            $service_id = session('booking_service_id');
            if (!$service_id) {
                throw new \Exception('Booking details not found in session');
            }

            // Get the service to ensure it exists and get trainer details
            $service = TrainerService::findOrFail($service_id);

            // Create the booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'trainer_id' => $service->trainer_id,
                'service_id' => $service_id,
                'session_date' => session('booking_session_date'),
                'notes' => session('booking_notes'),
                'status' => 'pending',
                'payment_status' => 'paid',
                'amount_paid' => $intent->amount / 100, // Convert from cents to dollars
                'stripe_payment_intent_id' => $payment_intent,
                'paid_at' => now(),
            ]);

            \Log::info('Booking created successfully', ['booking_id' => $booking->id]);

            // Clear the session data
            session()->forget(['booking_service_id', 'booking_session_date', 'booking_notes']);

            // Redirect to the booking details page
            return redirect()->route('bookings.show', $booking)
                           ->with('success', 'Your booking has been confirmed!');

        } catch (\Exception $e) {
            \Log::error('Payment completion failed: ' . $e->getMessage());
            
            // Clear the session data to prevent stale data
            session()->forget(['booking_service_id', 'booking_session_date', 'booking_notes']);
            
            return redirect()->route('services.index')
                           ->with('error', 'There was a problem confirming your booking: ' . $e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        // Allow viewing if user is the booking owner or the trainer
        $user = auth()->user();
        if ($user->id === $booking->user_id || 
            ($user->role === 'trainer' && $user->trainer && $user->trainer->id === $booking->trainer_id)) {
            $booking->load(['trainer.user', 'service']);
            return view('bookings.show', compact('booking'));
        }

        abort(403, 'You are not authorized to view this booking.');
    }

    public function cancel(Booking $booking)
    {
        // Only allow cancellation by the booking owner
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'You are not authorized to cancel this booking.');
        }
        
        if ($booking->status === 'pending' || $booking->status === 'confirmed') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking cancelled successfully.');
        }

        return redirect()->route('bookings.show', $booking)
            ->with('error', 'This booking cannot be cancelled.');
    }

    public function trainerBookings()
    {
        $user = auth()->user();
        
        if (!$user->isTrainer()) {
            abort(403, 'Only trainers can access this page.');
        }

        $bookings = Booking::where('trainer_id', $user->trainer->id)
            ->with(['user', 'service'])
            ->latest()
            ->get()
            ->groupBy(function($booking) {
                return $booking->status;
            });

        return view('bookings.trainer-index', compact('bookings'));
    }

    public function clearCancelledBookings()
    {
        $user = auth()->user();
        
        if (!$user->isTrainer()) {
            abort(403, 'Only trainers can access this page.');
        }

        try {
            // Delete all cancelled bookings for this trainer
            $deleted = Booking::where('trainer_id', $user->trainer->id)
                ->where('status', 'cancelled')
                ->delete();

            return redirect()->route('trainer.bookings')
                ->with('success', 'Successfully cleared cancelled bookings.');
        } catch (\Exception $e) {
            return redirect()->route('trainer.bookings')
                ->with('error', 'Failed to clear cancelled bookings. Please try again.');
        }
    }

    public function acceptBooking(Booking $booking)
    {
        $user = auth()->user();
        
        if (!$user->isTrainer() || $user->trainer->id !== $booking->trainer_id) {
            abort(403, 'You are not authorized to accept this booking.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('trainer.bookings')
                ->with('error', 'This booking cannot be accepted.');
        }

        $booking->update(['status' => 'confirmed']);

        // TODO: Send notification to user about booking confirmation

        return redirect()->route('trainer.bookings')
            ->with('success', 'Booking accepted successfully.');
    }

    public function declineBooking(Booking $booking)
    {
        $user = auth()->user();
        
        if (!$user->isTrainer() || $user->trainer->id !== $booking->trainer_id) {
            abort(403, 'You are not authorized to decline this booking.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('trainer.bookings')
                ->with('error', 'This booking cannot be declined.');
        }

        $booking->update(['status' => 'cancelled']);

        // TODO: Send notification to user about booking cancellation

        return redirect()->route('trainer.bookings')
            ->with('success', 'Booking declined successfully.');
    }
}
