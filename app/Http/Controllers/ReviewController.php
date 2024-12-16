<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ReviewController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    public function store(Request $request, Product $product)
    {
        \Log::info('Review Store Request', [
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        try {
            $review = new Review([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);

            $review->save();

            \Log::info('Review Created Successfully', [
                'review_id' => $review->id,
                'product_id' => $product->id,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Review Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $product->id,
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to submit review: ' . $e->getMessage());
        }
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }
}
