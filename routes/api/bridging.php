<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProbabilityController;
use Illuminate\Support\Facades\Route;



Route::get('/fetch/people/{nik}', [Controller::class, 'getIdentityPeople']);
Route::get('/fetch/people_attribute', [Controller::class, 'getIdentityPeopleByAttribute']);
Route::apiResource('probabilities', ProbabilityController::class);
