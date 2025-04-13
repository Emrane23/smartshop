<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $customer_id = auth('customer')->id();
        $category_id = $request->query('category');
        $productsQuery = Product::latest();

        if ($category_id) {
            $productsQuery->whereHas('categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            });
        }

        $products = $productsQuery->paginate(4);

        $recommended_products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->when($customer_id, function ($query) use ($customer_id) {
                $purchased_products = DB::table('order_items')
                    ->whereIn('order_id', Order::where('customer_id', $customer_id)->pluck('id'))
                    ->pluck('product_id')
                    ->toArray();

                return $query->whereNotIn('order_items.product_id', $purchased_products);
            })
            ->select('products.id', 'products.name', 'products.image', 'products.discount', DB::raw('COUNT(order_items.product_id) as popularity'))
            ->groupBy('products.id', 'products.name', 'products.image', 'products.discount')
            ->orderByDesc('popularity')
            ->limit(5)
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('frontoffice.pages.home', compact('products', 'recommended_products','categories', 'category_id'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);

        $otherProducts = Product::where('id', '!=', $id)->latest()->inRandomOrder()->take(4)->get();

        return view('frontoffice.pages.show-product', get_defined_vars());
    }
}
