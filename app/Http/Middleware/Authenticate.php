<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            session()->flash('info','You must log in first.');
            return route('login.show');
        }

        if ($request->user()) {
            if ($request->user()?->role == 'admin') {
                return route('dashboard.home');
            } else {
                return route('home');
            }
        }

        return null;
    }
}
