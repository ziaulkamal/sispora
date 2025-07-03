<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle(Request $request, Closure $next)
    {

        // Jika user sudah login
        if (Auth::check()) {
            // Cek sessionnya masih valid (misalnya gunakan session('key') atau ttl bawaan Laravel)
            if (!$request->session()->has('_token')) {
                // Jika session habis / hilang
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'session' => 'Sesi Anda telah berakhir. Silakan login kembali.'
                ]);
            }
        }

        return $next($request);
    }
}
