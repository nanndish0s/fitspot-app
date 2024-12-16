<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Fetch the latest 6 products, ordered by creation date
        $latestProducts = Product::latest()->take(6)->get();

        // Get user location if logged in and user role is 'user'
        $userLocation = null;
        if (auth()->check() && auth()->user()->role === 'user') {
            $userLocation = auth()->user()->location;
        }

        // Pass the latest products and user location to the view
        return view('home', compact('latestProducts', 'userLocation'));
    }
}
