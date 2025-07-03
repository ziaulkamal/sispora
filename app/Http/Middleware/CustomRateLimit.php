<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class CustomRateLimit
{
    public function handle($request, Closure $next, $maxAttempts = 10, $decaySeconds = 60)
    {
        $maxAttempts = intval($maxAttempts);
        $decaySeconds = intval($decaySeconds);

        $key = 'rate_limit:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Terlalu banyak permintaan. Silakan coba lagi dalam ' . RateLimiter::availableIn($key) . ' detik.'
            ], 429);
        }

        RateLimiter::hit($key, $decaySeconds);

        return $next($request);
    }
}