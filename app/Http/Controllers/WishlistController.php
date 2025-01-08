<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\TrainerService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistServices = Auth::user()->wishlist()->with('service')->whereNotNull('service_id')->get();
        $wishlistProducts = Auth::user()->wishlist()->with('product')->whereNotNull('product_id')->get();
        return view('wishlist.index', compact('wishlistServices', 'wishlistProducts'));
    }

    public function store(Request $request)
    {
        // Debug: Log the entire request
        \Log::info('Wishlist Store Request:', [
            'user' => Auth::id(),
            'request' => $request->all()
        ]);

        $request->validate([
            'service_id' => 'nullable|exists:trainer_services,id',
            'product_id' => 'nullable|exists:products,id'
        ]);

        // Validate that only one of service_id or product_id is provided
        $serviceId = $request->input('service_id');
        $productId = $request->input('product_id');

        // Debug: Log the parsed IDs
        \Log::info('Wishlist Item IDs:', [
            'service_id' => $serviceId,
            'product_id' => $productId
        ]);

        if (($serviceId && $productId) || (!$serviceId && !$productId)) {
            \Log::warning('Invalid wishlist item', [
                'service_id' => $serviceId,
                'product_id' => $productId
            ]);
            
            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Invalid wishlist item'
                ], 400);
            }
            
            return back()->with('error', 'Invalid wishlist item');
        }

        // Check if already in wishlist
        $existingWishlistItem = Wishlist::findExistingItem(Auth::id(), $serviceId, $productId)->first();

        if ($existingWishlistItem) {
            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Item is already in your wishlist'
                ], 409);
            }
            
            return back()->with('error', 'Item is already in your wishlist');
        }

        // Add to wishlist
        $wishlistItem = Wishlist::create([
            'user_id' => Auth::id(),
            'service_id' => $serviceId,
            'product_id' => $productId
        ]);

        // Debug: Log the created wishlist item
        \Log::info('Wishlist Item Created:', [
            'id' => $wishlistItem->id,
            'user_id' => $wishlistItem->user_id,
            'service_id' => $wishlistItem->service_id,
            'product_id' => $wishlistItem->product_id
        ]);

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => 'Item added to wishlist',
                'item' => $wishlistItem
            ]);
        }
        
        return back()->with('success', 'Item added to wishlist');
    }

    public function destroy($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);

        // Ensure user can only delete their own wishlist items
        if ($wishlistItem->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $wishlistItem->delete();
        return back()->with('success', 'Item removed from wishlist');
    }
}
