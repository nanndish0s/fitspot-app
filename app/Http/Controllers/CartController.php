<?php

namespace App\Http\Controllers;
use App\Models\Product; // Add this import
use App\Models\Cart;     // Import the Cart model
use Illuminate\Support\Facades\Auth;  // <-- Import the Auth facade
use App\Models\CartItem;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    // Add a product to the cart
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        // Check if the product is already in the user's cart
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // If the product is already in the cart, update the quantity
            $cartItem->quantity += 1;  // You can also change this to increase by a custom value
            $cartItem->save();
        } else {
            // If the product is not in the cart, create a new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,  // Set initial quantity to 1
            ]);
        }

        return redirect()->route('cart');  // Redirect to cart page after adding
    }

    // Show the user's cart
    public function index()
    {
          // Fetch the user's cart items with the associated product details
        $cartItems = auth()->user()->cart()->with('product')->get();

        // Calculate the total price of the items in the cart
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Return the view with cartItems and total price
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function removeFromCart($id)
    {
        \Log::info('Attempting to remove cart item', [
            'cart_item_id' => $id,
            'user_id' => auth()->id()
        ]);

        try {
            // Find the cart item using the Cart model
            $cartItem = Cart::where('id', $id)
                            ->where('user_id', auth()->id())
                            ->first();

            // Log details about the found cart item
            if (!$cartItem) {
                \Log::warning('Cart item not found', [
                    'cart_item_id' => $id,
                    'current_user_id' => auth()->id()
                ]);
                return redirect()->route('cart')->with('error', 'Cart item not found.');
            }

            \Log::info('Cart item found', [
                'cart_item_details' => $cartItem->toArray()
            ]);

            // Delete the cart item
            $result = $cartItem->delete();

            \Log::info('Cart item removal result', [
                'deleted' => $result,
                'cart_item_id' => $id
            ]);

            // Redirect back to the cart with a success message
            return redirect()->route('cart')->with('success', 'Item removed from the cart.');
        } catch (\Exception $e) {
            // Log the full error details
            \Log::error('Cart removal error', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'cart_item_id' => $id,
                'user_id' => auth()->id()
            ]);
            
            // Redirect back with an error message
            return redirect()->route('cart')->with('error', 'Unable to remove item from cart: ' . $e->getMessage());
        }
    }
    

    public function updateQuantity(Request $request, Cart $cartItem)
    {
         // Validate the new quantity
         $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Update the quantity of the product in the cart
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        // Redirect back to the cart page with a success message
        return redirect()->route('cart')->with('success', 'Cart updated successfully!');  
    }
}
