<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web.auth', 'limits:10,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        //         index
        // store
        // show
        // update
        // destroy

        Route::get('people', [PersonController::class, 'index'])->name('web.people.index');
        Route::post('people', [PersonController::class, 'store'])->name('web.people.store');
        Route::get('people/{id}', [PersonController::class, 'show'])->name('web.people.show');
        Route::post('people/{id}', [PersonController::class, 'update'])->name('web.people.patch');
        Route::delete('people/{id}', [PersonController::class, 'destroy'])->name('web.people.destroy');
        Route::get('people_edit/{id}', [PersonController::class, 'edit'])->name('people.edit');
});