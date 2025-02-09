<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Vendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next = null, $guard = null)
    {

        if (Auth::guard($guard)->check()) {

            return $next($request);

        } else {
            return redirect()->route('vendor.login');
        }
    }
}