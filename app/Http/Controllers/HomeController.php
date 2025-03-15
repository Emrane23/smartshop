<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $customer_id = auth('customer')->id();

        $products = Product::orderBy('created_at','DESC')->paginate(3);

            $recommended_products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->when($customer_id, function ($query) use ($customer_id) {
                $purchased_products = DB::table('order_items')
                    ->whereIn('order_id', Order::where('customer_id', $customer_id)->pluck('id'))
                    ->pluck('product_id')
                    ->toArray();

                return $query->whereNotIn('order_items.product_id', $purchased_products);
            })
            ->select('products.id', 'products.name', 'products.image', DB::raw('COUNT(order_items.product_id) as popularity'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('popularity')
            ->limit(5)
            ->get();

        return view('frontoffice.pages.home', compact('products', 'recommended_products'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        $otherProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->latest();

        return view('frontoffice.pages.show-product', compact('product', 'otherProducts'));
    }
}
