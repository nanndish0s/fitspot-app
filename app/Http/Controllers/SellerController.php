<?php

// app/Http/Controllers/SellerController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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

        // Pass products to the view
        return view('seller.dashboard', compact('products'));
    }
}

