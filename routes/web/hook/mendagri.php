<?php

use App\Http\Controllers\API\MendagriController;
use App\Http\Middleware\AuthOrSanctum;
use Illuminate\Support\Facades\Route;

Route::middleware(['limits:100,10'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(function () {
        Route::get('provinces', [MendagriController::class, 'getProvinces'])->name('web.mendagri.provinces');
        Route::get('regencies/{provinceId}', [MendagriController::class, 'getRegencies'])->name('web.mendagri.regencies');
        Route::get('districts/{regencyId}', [MendagriController::class, 'getDistricts'])->name('web.mendagri.districts');
        Route::get('villages/{districtId}', [MendagriController::class, 'getVillages'])->name('web.mendagri.villages');
        Route::get('kontingens', [MendagriController::class, 'getKontingens'])->name('web.mendagri.kontingens');
});

