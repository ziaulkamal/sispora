<?php

namespace App\Http\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardPage
{
    public function __invoke()
    {
        // dd(Auth::check());
        return view('app.index', [
            'title' => 'Dashboard',
            // Tambahkan data lain jika perlu
        ]);
    }
}
