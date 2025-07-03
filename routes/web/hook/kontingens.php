<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontingenController;

Route::middleware(['web.auth', 'limits:5,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(function () {
        Route::get('kontingen-register', [KontingenController::class, 'kontingenRegister'])->name('web.kontingen.register');
        Route::get('kontingen', [KontingenController::class, 'index']);
        Route::post('kontingen', [KontingenController::class, 'store']);
        Route::get('kontingen/{id}', [KontingenController::class, 'show']);
        Route::patch('kontingen/{id}', [KontingenController::class, 'update']);
        Route::delete('kontingen/{id}', [KontingenController::class, 'destroy']);
});
