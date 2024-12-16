<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = auth()->user()->cart()->with('product')->get();

        // Validate cart is not empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Start a database transaction
        return DB::transaction(function () use ($cartItems) {
            // Calculate total
            $total = $cartItems->sum(function ($cartItem) {
                return $cartItem->quantity * $cartItem->product->price;
            });

            // Create an order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Prepare line items for Stripe
            $lineItems = [];
            foreach ($cartItems as $cartItem) {
                // Create order items
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]);

                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => $cartItem->product->name,
                            'images' => $cartItem->product->image ? [asset('storage/'.$cartItem->product->image)] : [],
                        ],
                        'unit_amount' => $cartItem->product->price * 100, // Stripe expects amounts in cents
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            }

            try {
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('checkout.success', ['order_id' => $order->id]).'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('cart'),
                    'metadata' => [
                        'user_id' => auth()->id(),
                        'order_id' => $order->id
                    ]
                ]);

                // Update order with Stripe session ID if needed
                $order->update([
                    'payment_intent_id' => $session->id
                ]);

                return redirect($session->url);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // Log the error
                \Log::error('Stripe Checkout Error: ' . $e->getMessage());
                return redirect()->route('cart')->with('error', 'Payment processing failed: ' . $e->getMessage());
            }
        });
    }

    public function success(Request $request, $order_id)
    {
        if (!$request->session_id) {
            return redirect()->route('cart.index');
        }

        // Verify the payment with Stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            $session = \Stripe\Checkout\Session::retrieve($request->session_id);
            
            // Update order status
            $order = Order::findOrFail($order_id);
            $order->update(['status' => 'completed']);

            // Clear the user's cart after successful payment
            auth()->user()->cart()->delete();

            return view('checkout.success', compact('order'));
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->route('cart.index')->with('error', 'Payment verification failed');
        }
    }
}
