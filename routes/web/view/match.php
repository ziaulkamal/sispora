<?php

use App\Http\Pages\SchedulePage;
use Illuminate\Support\Facades\Route;


Route::get('schedule/f/insert', [SchedulePage::class, 'scheduleInsert'])->name('view.schedule.insert');
Route::get('schedule/t/data', SchedulePage::class)->name('view.schedule.index');
