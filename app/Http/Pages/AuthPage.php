<?php

namespace App\Http\Pages;

use Illuminate\Support\Facades\View;

class AuthPage
{
    public function __invoke()
    {
        return view('auth.index', [
            // 'title' => 'Dashboard',
            // Tambahkan data lain jika perlu
        ]);
    }
}
