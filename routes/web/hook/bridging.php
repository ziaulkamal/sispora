<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProbabilityController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web.auth', 'limits:50,5'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        Route::get('fetch/people/{nik}', [Controller::class, 'getIdentityPeople'])->name('web.people.fetch');
        Route::get('fetch/people_attribute', [Controller::class, 'getIdentityPeopleByAttribute'])->name('web.people.fetch.attribute');
        Route::get('probabilities', [ProbabilityController::class, 'index'])->name('web.probabilities.index');
        Route::post('probabilities', [ProbabilityController::class, 'store'])->name('web.probabilities.store');
        Route::get('probabilities/{id}', [ProbabilityController::class, 'show'])->name('web.probabilities.show');
        Route::post('probabilities/{id}', [ProbabilityController::class, 'update'])->name('web.probabilities.update');
        Route::delete('probabilities/{id}', [ProbabilityController::class, 'destroy'])->name('web.probabilities.destroy');
    });
