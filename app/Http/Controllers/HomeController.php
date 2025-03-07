<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::paginate(3);
        return view('frontoffice.pages.home', get_defined_vars());
    }
}
