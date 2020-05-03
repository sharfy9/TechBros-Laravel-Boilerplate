<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckActive
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
        if(!Auth::check() || Auth::user()->hasRole('Super Admin'))
        return $next($request);

        if(!Auth::user()->active){
            Auth::logout();
            return redirect('/login')->withErrors(['Your Account is Inactive. Contact vendor.'])->withInput();
        }
        elseif(Auth::user()->vendor_id){
            if(!Auth::user()->vendor->active){
                Auth::logout();
                return redirect('/login')->withErrors(['Your Vendor Account is Inactive. Contact Administrator.'])->withInput();
            }
            elseif(Auth::user()->vendor->expires_at != null && time() > strtotime(Auth::user()->vendor->expires_at)){
                Auth::logout();
                return redirect('/login')->withErrors(['Your Vendor Account has expired. Contact Administrator.'])->withInput();
            }
        }
        // else{
        //     Auth::logout();
        //     return redirect('/login')->withErrors(['Your account is not linked with any vendor. Contact Administrator.'])->withInput();
        // }
        return $next($request);
    }
}
