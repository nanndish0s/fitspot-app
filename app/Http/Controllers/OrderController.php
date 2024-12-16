<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch the logged-in user's orders with their items and products
        $orders = auth()->user()->orders()->with(['orderItems.product'])->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure the user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Load order items with their associated products
        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
