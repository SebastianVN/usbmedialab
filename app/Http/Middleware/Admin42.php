<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin42
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
        if(Auth::check()) 
            if(Auth::user()->level >= 16)
                return $next($request);
            return redirect('/');
        return redirect('/login');
    }
}