<?php

use App\Http\Controllers\SportController;
use App\Http\Controllers\SportsSubController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web.auth','limits:200,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {

        Route::get('sports', [SportController::class, 'index'])->name('web.sports.index');
        Route::post('sports', [SportController::class, 'store'])->name('web.sports.store');
        Route::get('sports/{id}', [SportController::class, 'show'])->name('web.sports.show');
        Route::post('sports/{id}', [SportController::class, 'update'])->name('web.sports.patch');
        Route::delete('sports/{id}', [SportController::class, 'destroy'])->name('web.sports.destroy');
        Route::get('sports_specialCase/{id}', [SportController::class, 'specialCase'])->name('web.sports.special-case');

        Route::post('sport/subs/store', [SportsSubController::class, 'store'])->name('web.sports.subs.store');
        Route::delete('sports-subs/{id}', [SportsSubController::class, 'destroy'])->name('web.sports.subs.destroy');
});