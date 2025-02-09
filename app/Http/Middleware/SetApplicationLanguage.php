<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;
class SetApplicationLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $languages =  \Config::get('app.languages');
        $locale =$request->segment(1); //fetches first URI segment
        //for default language
        if (in_array($locale, $languages)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('en');
            $locale = null;
        }
        return $next($request);

        // if (session()->has('lang')){
        //     app()->setLocale(session('lang'));
        // }
        // else
        //     app()->setLocale('ar');

        // return $next($request);
    }
}
