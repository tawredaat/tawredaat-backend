<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Super
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next = null,$guard = null){
        if (Auth::guard($guard)->check()) {
            return $next($request);
            //return redirect('admin');
        }else{
            return redirect('admin/login');
        }
    }
}
