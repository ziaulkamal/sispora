<?php

use App\Http\Pages\VenuePage;
use Illuminate\Support\Facades\Route;


Route::get('venue/t/data', VenuePage::class)->name('view.venue.index');
Route::get('venue/t/insert', [VenuePage::class, 'insertVenue'])->name('view.venue.insert');
