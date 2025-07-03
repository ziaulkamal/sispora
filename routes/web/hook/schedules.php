<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdditionalScheduleController;

Route::middleware(['web.auth', 'limits:5,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        Route::apiResource('schedules', ScheduleController::class);
        Route::get('schedules', [ScheduleController::class, 'index'])->name('web.schedules.index');
        Route::post('schedules', [ScheduleController::class, 'store'])->name('web.schedules.store');
        Route::get('schedules/{id}', [ScheduleController::class, 'show'])->name('web.schedules.show');
        Route::post('schedules/{id}', [ScheduleController::class, 'update'])->name('web.schedules.patch');
        Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->name('web.schedules.destroy');
        Route::apiResource('additional-schedules', AdditionalScheduleController::class);
});