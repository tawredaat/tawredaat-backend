<?php

namespace App\Http\Middleware;

use Closure;

class CheckLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$locale)
    {
        if (!in_array($locale, config()->get('app.languages')))
            return redirect('/en');
        return $next($request);
    }
}
