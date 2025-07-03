<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('documents', DocumentController::class);
Route::patch('/documents/by-person/{peopleId}', [DocumentController::class, 'updateByPersonId']);
Route::post('/documents/upload/{peopleId}', [DocumentController::class, 'uploadDocument']);