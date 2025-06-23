<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;

Route::apiResource('athletes', AthleteController::class);
