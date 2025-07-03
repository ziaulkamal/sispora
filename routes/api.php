<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['api', 'sanctum.auth'])->group(function () {
    foreach (glob(base_path('routes/api/*.php')) as $filename) {
        require $filename;
    }
});