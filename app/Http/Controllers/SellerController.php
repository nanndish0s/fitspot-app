<?php

// app/Http/Controllers/SellerController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    // Show the seller dashboard and list their products
    public function index()
    {
        // Check if the logged-in user is a seller
        if (auth()->user()->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Access denied. You must be a seller to view this page.');
        }

        // Get products for the logged-in seller
        $products = auth()->user()->products;

        // Calculate total revenue
        $totalRevenue = OrderItem::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->sum(DB::raw('quantity * price'));

        // Calculate total orders (unique orders containing seller's products)
        $totalOrders = Order::whereHas('orderItems.product', function ($query) {
            $query->where('user_id', auth()->id());
        })->distinct()->count('id');

        // Calculate average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Product statistics
        $totalProducts = $products->count();
        $activeProducts = $products->where('quantity', '>', 0)->count();
        $outOfStockProducts = $products->where('quantity', 0)->count();

        // Recent products (last 5 added)
        $recentProducts = $products->sortByDesc('created_at')->take(5);

        // Pass all statistics to the view
        return view('seller.dashboard', compact(
            'products', 
            'totalRevenue', 
            'totalOrders', 
            'averageOrderValue', 
            'totalProducts', 
            'activeProducts', 
            'outOfStockProducts', 
            'recentProducts'
        ));
    }

    public function manageProducts()
    {
        // Check if the logged-in user is a seller
        if (auth()->user()->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Access denied. You must be a seller to view this page.');
        }

        // Get products for the logged-in seller with pagination
        $products = auth()->user()->products()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function sellerOrders()
    {
        // Check if the logged-in user is a seller
        if (auth()->user()->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Access denied. You must be a seller to view this page.');
        }

        // Get orders containing the seller's products
        $sellerOrders = Order::whereHas('orderItems.product', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['orderItems' => function ($query) {
            $query->whereHas('product', function ($subQuery) {
                $subQuery->where('user_id', auth()->id());
            });
        }])
        ->latest()
        ->paginate(10);

        return view('orders.seller_index', compact('sellerOrders'));
    }
}
