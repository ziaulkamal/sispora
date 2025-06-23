<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;


Route::get('/fetch/people/{nik}', [Controller::class, 'getIdentityPeople'])->name('fetch.people');
Route::get('/fetch/people_attribute', [Controller::class, 'getIdentityPeopleByAttribute']);


