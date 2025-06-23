<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportController;

Route::apiResource('sports', SportController::class);
