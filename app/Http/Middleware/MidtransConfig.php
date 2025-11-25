<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class MidtransConfig
{
    public function handle(Request $request, Closure $next)
    {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$clientKey = config('services.midtrans.client_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        return $next($request);
    }   
}
