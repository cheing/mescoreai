<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // If not, redirect to a different page or show an error
            return redirect('/')->with('error', 'You do not have access to this section.');
        }

        return $next($request);
    }
}
