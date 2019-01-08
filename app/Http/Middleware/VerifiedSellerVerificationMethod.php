<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedSellerVerificationMethod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $method = '')
    {
        if (
            !session('seller.verification.verified')
                || session('seller.verification.method') != $method
        ) {
            return $next($request);
        }

        return redirect()->route('seller.register');
    }
}
