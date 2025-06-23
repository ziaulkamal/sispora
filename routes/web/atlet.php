<?php

use App\Http\Pages\AtletPage;
use Illuminate\Support\Facades\Route;


Route::get('atlet/f/register_atlet', [AtletPage::class, 'atletForm'])->name('form.atlet');
Route::get('atlet/f/edit_atlet/{id}', [AtletPage::class, 'atletFormEdit'])->name('form.atlet.edit');
Route::get('atlet/t/data', AtletPage::class)->name('table.atlet');
