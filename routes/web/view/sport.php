<?php

use App\Http\Controllers\SportsSubController;
use App\Http\Pages\SportPage;
use Illuminate\Support\Facades\Route;


Route::get('sport/t/data', SportPage::class )->name('view.sport.index');
Route::get('sport/t/insert', [SportPage::class, 'sportForm'] )->name('view.sport.insert');
Route::get('sports/t/update/{id}', [SportPage::class, 'updateSportForm'] )->name('view.sport.update');
Route::get('sport/t/subs/{id}', [SportPage::class, 'subsportdata'] )->name('view.sport.subs');

