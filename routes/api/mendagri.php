<?php

use App\Http\Controllers\API\MendagriController;
use App\Http\Middleware\AuthOrSanctum;
use Illuminate\Support\Facades\Route;

Route::middleware(['limits:2,10'])->group(function () {
    Route::get('/provinces', [MendagriController::class, 'getProvinces']);
    Route::get('/regencies/{provinceId}', [MendagriController::class, 'getRegencies']);
    Route::get('/districts/{regencyId}', [MendagriController::class, 'getDistricts']);
    Route::get('/villages/{districtId}', [MendagriController::class, 'getVillages']);
    Route::get('/kontingens', [MendagriController::class, 'getKontingens']);
});
