<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckBasicInfo
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
        if(Auth::check() && (!Auth::user()->phone || !Auth::user()->password) && request()->path() != "complete-registration")
        return redirect("/complete-registration")->withErrors(['Please Enter Phone Number and Set Password']);
        else
        return $next($request);
    }
}
