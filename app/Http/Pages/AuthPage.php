<?php

namespace App\Http\Pages;

use Illuminate\Support\Facades\View;

class AuthPage
{
    public function pageLogin()
    {
        return view('auth.index', [
            'title' => 'PORA XV AUTH',
            'section' => 'auth',
            // Tambahkan data lain jika perlu
        ]);
    }
}
