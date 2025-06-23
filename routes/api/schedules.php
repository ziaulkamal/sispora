<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdditionalScheduleController;

Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('additional-schedules', AdditionalScheduleController::class);
