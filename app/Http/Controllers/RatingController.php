<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RatingController extends Controller
{
    public function sendRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $customer = auth()->guard('customer')->user();
        $product = Product::findOrFail($request->product_id);

        if (!$product->canRate($customer->id)) {
            return response()->json(['success' => false, 'message' => 'You cannot rate this product.'], 403);
        }

        $existingRating = Rating::where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->where('customer_id', $customer->id)
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        } else {
            Rating::create([
                'customer_id' => $customer->id,
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        Cache::forget("product_rating_distribution_{$request->product_id}");

        return response()->json([
            'success' => true,
            'message' => 'Your review has been submitted!',
            'newRating' => number_format($product->ratings()->avg('rating'), 1, ','),
            'totalReviews' => $product->ratings()->count(),
        ]);
    }

    public function getRatingDistribution($productId)
    {
        $cacheKey = "product_rating_distribution_{$productId}";

        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($productId) {
            $ratings = Rating::where('product_id', $productId)->get();

            $averageRating = number_format($ratings->avg('rating'), 1, ',') ?? 0;

            $totalReviews = $ratings->count();

            $distribution = collect([5, 4, 3, 2, 1])->mapWithKeys(fn($star) => [
                $star => $ratings->where('rating', $star)->count()
            ]);

            return [
                'rating' => $averageRating,
                'totalReviews' => $totalReviews,
                'ratingDistribution' => $distribution
            ];
        });

        return response()->json($data);
    }
}
