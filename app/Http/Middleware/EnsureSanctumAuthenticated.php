<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSanctumAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user tidak terautentikasi via sanctum
        if (!$request->user('sanctum')) {
            return response()->json(['message' => 'Unauthorized. Sanctum token required.'], 401);
        }

        return $next($request);
    }
}
