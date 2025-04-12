<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $sales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name as product_name, SUM(order_items.quantity) as total_sales')
            ->groupBy('products.name')
            ->get();

        $predictions = $sales->map(function ($sale) {
            return (object) [
                'product_name' => $sale->product_name,
                'predicted_sales' => $sale->total_sales * 1.1,
            ];
        });

        return view('dashboard.home', get_defined_vars());
    }
}
