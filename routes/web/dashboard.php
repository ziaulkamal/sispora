<?php

use App\Http\Pages\DashboardPage;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', DashboardPage::class)->name('dashboard');
