<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;

Route::middleware(['web.auth', 'limits:5,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {

        Route::get('venues', [VenueController::class, 'index'])->name('web.venues.index');
        Route::post('venues', [VenueController::class, 'store'])->name('web.venues.store');
        Route::get('venues/{id}', [VenueController::class, 'show'])->name('web.venues.show');
        Route::post('venues/{id}', [VenueController::class, 'update'])->name('web.venues.update');
        Route::delete('venues/{id}', [VenueController::class, 'destroy'])->name('web.venues.destroy');
});