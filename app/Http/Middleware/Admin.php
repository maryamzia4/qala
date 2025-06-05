<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Redirect non-admin users to the home page
            return redirect('/');
        }

        return $next($request);
    }
}
