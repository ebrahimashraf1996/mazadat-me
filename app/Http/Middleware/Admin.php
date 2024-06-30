<?php

namespace App\Http\Middleware;
use Closure;
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
    public function handle($request, Closure $next = null, $guard = null)
    { 
        if(Auth::guard('admin')->check())
        {
          return $next($request);
        }
        elseif(Auth::guard('auction')->check()){
          return $next($request);
        }
        elseif(Auth::guard('delivery')->check()){
          return $next($request);
        }
        else{
          return redirect()->route('selection');
        }
    }
}
