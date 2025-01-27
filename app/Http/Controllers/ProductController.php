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

    public function sellerIndex()
    {
        // Ensure only sellers can access this method
        if (auth()->user()->role !== 'seller') {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        // Fetch only the logged-in seller's products with pagination
        $products = auth()->user()->products()->latest()->paginate(10);

        return view('products.seller_index', compact('products'));
    }

    public function edit(Product $product)
    {
        // Ensure the product belongs to the logged-in seller
        if ($product->user_id !== auth()->id()) {
            return redirect()->route('seller.products')->with('error', 'You are not authorized to edit this product.');
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure the product belongs to the logged-in seller
        if ($product->user_id !== auth()->id()) {
            return redirect()->route('seller.products')->with('error', 'You are not authorized to update this product.');
        }

        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path) {
                Storage::delete($product->image_path);
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        // Update the product
        $product->update($validatedData);

        return redirect()->route('seller.products')
            ->with('success', 'Product updated successfully.');
    }

    public function destroySeller(Product $product)
    {
        // Ensure the product belongs to the logged-in seller
        if ($product->user_id !== auth()->id()) {
            return redirect()->route('seller.products')->with('error', 'You are not authorized to delete this product.');
        }

        // Delete product image if exists
        if ($product->image_path) {
            Storage::delete($product->image_path);
        }

        // Delete the product
        $product->delete();

        return redirect()->route('seller.products')
            ->with('success', 'Product deleted successfully.');
    }
}
