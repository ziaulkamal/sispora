<?php

use App\Http\Controllers\API\MendagriController;
use Illuminate\Support\Facades\Route;


Route::get('/provinces', [MendagriController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [MendagriController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [MendagriController::class, 'getDistricts']);
Route::get('/villages/{districtId}', [MendagriController::class, 'getVillages']);
Route::get('/kontingens', [MendagriController::class, 'getKontingens']);