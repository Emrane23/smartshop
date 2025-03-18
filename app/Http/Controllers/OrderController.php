<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\LoyaltyReward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->orderBy('created_at', 'DESC')->get();
        return view('dashboard.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => ['required', 'array', 'min:1'],
            'products.*' => ['exists:products,id'],
        ], [
            'products.required' => 'You must add at least one product to your order.',
            'products.min' => 'You must select at least one product.',
            'products.*.exists' => 'One of the selected products does not exist.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'La validation a échoué.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $customer = auth()->guard('customer')->user();
            $loyaltyDiscount = 0;

            if ($customer->points >= 100) {
                $loyaltyDiscount = 10;
                $customer->decrement('points', 100);
            }

            $orderItems = [];
            $total = 0;

            $productCounts = array_count_values($request->products);
            $productIds = array_keys($productCounts);
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($productCounts as $productId => $quantity) {
                $product = $products->get($productId);

                if (!$product) {
                    throw new \Exception("Product ID {$productId} does not exist.");
                }

                if ($product->stock >= $quantity) {
                    $price = (float) $product->price;
                    $discountedPrice = $product->discount ? $price - ($price * $product->discount / 100) : $price;

                    $orderItems[$product->id] = [
                        'quantity' => $quantity,
                        'price' => $discountedPrice,
                    ];

                    $product->decrement('stock', $quantity);

                    $total += $discountedPrice * $quantity;
                } else {
                    throw new \Exception("The product {$product->name} does not have enough stock.");
                }
            }

            $finalTotal = max($total - $loyaltyDiscount, 0);

            $order = Order::create([
                'customer_id' => $customer->id,
                'total' => $finalTotal,
            ]);

            $order->products()->attach($orderItems);

            $pointsEarned = floor($finalTotal / 10);
            $customer->increment('points', $pointsEarned);

            if ($customer->points >= 500) {
                if (!$customer->reward_notified) {
                    Notification::send($customer, new LoyaltyReward($customer));
                    $customer->update(['reward_notified' => true]);
                }
            } else {
                $customer->update(['reward_notified' => false]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'total_final' => $finalTotal,
                'points_gagnés' => $pointsEarned,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error while placing the order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);
        $order = Order::find($request->order_id);

        if (in_array($order->status, ['canceled', 'completed'])) {
            return response()->json(['success' => false, 'message' => 'Cannot modify a canceled or completed order.'], 403);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'message' => "Status $request->status successfully.", 'newStatusResponse' => $order->status]);
    }
}
