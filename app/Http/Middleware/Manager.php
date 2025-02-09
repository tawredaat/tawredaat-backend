<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next = null,$guard = null){
    // AND Auth::guard($guard)->user()->privilege=='manager'
        if (Auth::guard($guard)->check() ) {
            return $next($request);
            //return redirect('admin');
        }else{
           return redirect('admin/login');
        }
    }


}
