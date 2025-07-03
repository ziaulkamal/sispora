<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSecurely
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            logger('Auth via session', ['user' => Auth::user()]);
            return $next($request);
        }

        logger('Akses Tidak Dikenal', ['session' => session()->all()]);
        return response()->json(['message' => 'Akses Ditolak'], 401);
    }
}
