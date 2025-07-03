<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web.auth', 'limits:50,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        Route::apiResource('users', UserController::class);
});