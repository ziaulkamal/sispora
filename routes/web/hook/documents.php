<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web.auth', 'limits:50,30'])
    ->prefix('web') // <== ini akan menambahkan prefix ke semua route di group
    ->group(
    function () {
        // Route::apiResource('documents', DocumentController::class);
        Route::patch('documents/by-person/{peopleId}', [DocumentController::class, 'updateByPersonId'])->name('web.documents.update.by-person');
        Route::post('documents/upload/{peopleId}', [DocumentController::class, 'uploadDocument'])->name('web.documents.upload');
});