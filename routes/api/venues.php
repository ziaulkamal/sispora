<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;

Route::apiResource('venues', VenueController::class);
