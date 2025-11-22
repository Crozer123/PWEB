<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'customer') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You do not have customer access.');
    }
}
