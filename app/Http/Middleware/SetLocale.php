<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, \Closure $next)
    {
        // Check if the session has 'locale' and if it's a supported locale
        if ($locale = Session::get('locale')) {
            // Set the app locale to the one stored in the session
            App::setLocale($locale);
            Carbon::setLocale($locale);  // Set Carbon's locale
        }

        return $next($request);
    }
}
