<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    
    public function CustomerArea()
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->latest()->get();

        return view('frontoffice.pages.customer-area', compact('customer', 'orders'));
    }
}
