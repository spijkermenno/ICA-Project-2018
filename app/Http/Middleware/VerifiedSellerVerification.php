<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedSellerVerification
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
        if (session('seller.verification.verified')) {
            return $next($request);
        }
        return redirect()->route('seller.verify');
    }
}
