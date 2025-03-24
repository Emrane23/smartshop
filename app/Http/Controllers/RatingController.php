<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($request, $customer, $product) {
            $rating = Rating::updateOrCreate(
                [
                    'order_id' => $request->order_id,
                    'product_id' => $request->product_id,
                    'customer_id' => $customer->id,
                ],
                [
                    'rating' => $request->rating,
                ]
            );

            if ($request->filled('comment')) {
                Comment::updateOrCreate(
                    [
                        'rating_id' => $rating->id,
                    ],
                    [
                        'comment' => $request->comment,
                        'published_at' => $request->rating >= 4 ? now() : null,
                    ]
                );
            }
        });

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
