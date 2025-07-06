<?php

use App\Http\Pages\SchedulePage;
use Illuminate\Support\Facades\Route;


Route::get('schedule/f/insert', [SchedulePage::class, 'scheduleInsert'])->name('view.schedule.insert');
Route::get('schedule/d/detail/{id}', [SchedulePage::class, 'scheduleDetail'])->name('view.schedule.detail');
Route::get('schedule/w/detail/{id}', [SchedulePage::class, 'scheduleUpdate'])->name('view.schedule.wasit.update');
Route::get('schedule/t/data', SchedulePage::class)->name('view.schedule.index');

Route::get('schedule/f/series/insert', [SchedulePage::class, 'makeSeriesSports'])->name('view.schedule.series.insert');
Route::get('schedule/t/series/data', [SchedulePage::class, 'seriesSports'])->name('view.schedule.series.index');
