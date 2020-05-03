<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class TwoFactorAuthenticate
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
        $authenticator = app(Authenticator::class)->boot($request);

        if (Auth::user()->google2fa_secret != null) {
            if (!$authenticator->isAuthenticated()) {
                return $authenticator->makeRequestOneTimePasswordResponse();
            }
        }

        return $next($request);
    }
}
