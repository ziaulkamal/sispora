<?php

use App\Http\Pages\AtletPage;
use App\Http\Pages\DocumentsPage;
use Illuminate\Support\Facades\Route;



Route::get('atlet/f/register_atlet', [AtletPage::class, 'atletForm'])->name('form.atlet');
Route::get('atlet/f/edit_atlet/{id}', [AtletPage::class, 'atletFormEdit'])->name('form.atlet.edit');
Route::get('atlet/v/data/{id}', [AtletPage::class, 'atletDetail'])->name('view.atlet.detail');
Route::get('atlet/t/data', AtletPage::class)->name('table.atlet');
Route::get('atlet/d/detail/{peopleId}', [DocumentsPage::class, 'detail'])->name('dokument.atlet');

