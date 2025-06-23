<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('documents', DocumentController::class);
