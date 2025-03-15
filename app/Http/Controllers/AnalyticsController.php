<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
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

    public function exportPDF()
    {
        $sales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name as product_name, SUM(order_items.quantity) as total_sales')
            ->groupBy('order_items.product_id', 'products.name')
            ->get();

        $sales = $sales->map(function ($sale) {
            $sale->predicted_sales = $sale->total_sales * 1.1; // +10% pour la prédiction
            return $sale;
        });
        $pdf = Pdf::loadView('report', compact('sales'));

        return $pdf->download('rapport_ventes.pdf');
    }
}
