<?php

use App\Http\Controllers\SportController;
use App\Http\Controllers\SportsSubController;
use Illuminate\Support\Facades\Route;


Route::apiResource('sports', SportController::class);

Route::post('/sport/subs/store', [SportsSubController::class, 'store']);
Route::delete('/sports-subs/{id}', [SportsSubController::class, 'destroy']);
