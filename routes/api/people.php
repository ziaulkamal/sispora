<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::apiResource('people', PersonController::class);
Route::get('/people_edit/{id}', [PersonController::class, 'edit']);
