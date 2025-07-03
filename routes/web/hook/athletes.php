<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;

Route::middleware(['web.auth','limits:200,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        Route::get('athletes', [AthleteController::class, 'index'])->name('web.athletes.index');
        Route::post('athletes', [AthleteController::class, 'store'])->name('web.athletes.store');
        Route::get('athletes/{id}', [AthleteController::class, 'show'])->name('web.athletes.show');
        Route::post('athletes/{id}', [AthleteController::class, 'update'])->name('web.athletes.patch');
        Route::delete('athletes/{id}', [AthleteController::class, 'destroy'])->name('web.athletes.destroy');
});

