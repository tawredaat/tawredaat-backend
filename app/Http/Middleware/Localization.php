<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class Localization
{

    public function handle($request, Closure $next)
    {
        $lang = $request->header('content-language');
        if (isset($lang) && $lang == 'en') {
            App::setlocale('en');
        } else {
            App::setlocale('ar');
        }
        return $next($request);
    }
}
