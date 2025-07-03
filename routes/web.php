<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthOrSanctum;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use App\Http\Pages\AuthPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::middleware(['auth'])->group(function () {
        Route::prefix('applications')->group(function () {
            foreach (glob(base_path('routes/web/view/*.php')) as $first) {
                require $first;
            }
        });
    });

    foreach (glob(base_path('routes/web/hook/*.php')) as $seconds) {
        require $seconds;
    }

    Route::get('auth/login', [AuthPage::class, 'pageLogin'])->name('login');
    Route::post('auth/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'web.auth']);
});

