<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontingenController;

Route::apiResource('kontingens', KontingenController::class);

Route::get('kontingen-register', [KontingenController::class, 'kontingenRegister']);
