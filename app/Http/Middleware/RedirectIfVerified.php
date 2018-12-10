<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class RedirectIfVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (session('email.verification.verified') && Carbon::parse(session('auth.email.expired_at'))->lt(now())) {
            return redirect('/register');
        }

        return $next($request);
    }
}
