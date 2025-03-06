<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showPoints($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json(['points' => $customer->points]);
    }
}
