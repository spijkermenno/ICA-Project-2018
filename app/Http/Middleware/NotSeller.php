<?php

namespace App\Http\Middleware;

use Closure;

class NotSeller
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
        if (optional(auth()->user())->seller == 0) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
