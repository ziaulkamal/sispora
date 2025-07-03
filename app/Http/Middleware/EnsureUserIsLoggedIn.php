<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login DAN bukan sedang mengakses halaman login
        // dd(Auth::check());
        if (!Auth::check() && !$request->routeIs('login')) {
            return redirect()->route('login')->with('error', 'Silakan login dahulu.');
        }

        return $next($request);
    }
}
