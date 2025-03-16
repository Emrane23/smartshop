<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('web')->attempt($credentials) && auth()->user()->role == 'admin') {
            $name = auth()->user()->name;
            return redirect()->intended(route('dashboard.home'))->with(['success' => "Welcome $name"]);
        }
    
        if (Auth::guard('customer')->attempt($credentials)) {
            $name = auth()->guard('customer')->user()->name;
            return redirect()->intended(route('home'))->with(['success' => "Welcome $name"]);
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return to_route('home')->with('success',"Welcome to our word $customer->name !"); 
    }

    public function logout(Request $request)
    {
        $guards = ['web', 'customer'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return to_route('login.show')->with('info', 'Good Bye!');
    }
}
