<?php

use App\Http\Pages\AuthPage;
use Illuminate\Support\Facades\Route;



Route::get('auth', AuthPage::class)->name('auth.page');
