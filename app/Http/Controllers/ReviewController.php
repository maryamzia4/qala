<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeProductReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $user = Auth::user();

        // Check if the user has purchased this product
        $hasPurchased = $user->orders()->whereHas('items', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['review' => 'You must purchase this product before submitting a review.']);
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function destroy($id)
{
    $review = Review::findOrFail($id);
    $review->delete();

    return back()->with('success', 'Review deleted successfully.');
}

}
