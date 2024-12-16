<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show the product creation form
    public function create()
    {
        // Ensure only sellers can access this page
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Access denied');
        }

        return view('products.create');
    }

    // Store the product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
    
        // Store the product in the database
        $product = auth()->user()->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
        ]);
    
        // Redirect to seller dashboard
        return redirect()->route('seller.dashboard')->with('success', 'Product added successfully');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Delete the product image from storage if exists
    if ($product->image) {
        Storage::delete('public/' . $product->image);
    }

    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}




    // Display the list of products for the logged-in user (seller)
    public function index()
    {
        // Fetch all products with pagination
    $products = Product::paginate(10);  // Adjust the number (10) as needed for pagination

    return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Eager load reviews with their associated users
        $product->load('reviews.user');
        
        // Fetch related products based on price range
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereBetween('price', [
                max(0, $product->price * 0.8), 
                $product->price * 1.2
            ])
            ->take(4) // Limit to 4 related products
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }


    // app/Http/Controllers/ProductController.php

    public function edit(Product $product)
    {
        // You don't need to use findOrFail here because the $product 
        // variable is automatically populated by Laravel via route model binding.
     
        // Check if the logged-in user owns the product (optional, for security purposes)
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
     
        // Pass the product to the edit view
        return view('products.edit', compact('product'));
    }

public function update(Request $request, Product $product)
{
    // Ensure the product belongs to the authenticated user (seller)
    if ($product->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access');
    }

    // Validate the input data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Handle image upload if a new image is provided
    $imagePath = $product->image; // Keep the old image by default
    if ($request->hasFile('image')) {
        // Delete the old image if it's being replaced
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
        // Store the new image
        $imagePath = $request->file('image')->store('products', 'public');
    }

    // Update the product data in the database
    $product->update([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'image' => $imagePath, // Update the image path
    ]);

    // Redirect to the seller dashboard or the product list page
    return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully');
}

}
