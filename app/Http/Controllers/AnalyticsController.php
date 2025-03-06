<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function predictSales()
    {
        $sales = DB::table('order_items')
            ->selectRaw('product_id, SUM(quantity) as total_sales')
            ->groupBy('product_id')
            ->get();
    
        $predictions = $sales->map(function ($sale) {
            return (object) [
                'product_id' => $sale->product_id,
                'predicted_sales' => $sale->total_sales * 1.1, // Augmentation de 10%
            ];
        });
    
        return view('analytics', compact('sales', 'predictions'));
    }

    public function recommendProducts($customer_id)
    {
        $purchased_products = DB::table('order_items')
            ->whereIn('order_id', Order::where('customer_id', $customer_id)->pluck('id'))
            ->pluck('product_id');

        $recommended_products = DB::table('order_items')
            ->whereNotIn('product_id', $purchased_products)
            ->selectRaw('product_id, COUNT(*) as popularity')
            ->groupBy('product_id')
            ->orderByDesc('popularity')
            ->limit(5)
            ->get();

        return view('recommendations', compact('recommended_products'));
    }
}
