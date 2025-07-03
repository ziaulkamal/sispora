<?php

namespace App\Http\Pages;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Support\Facades\View;

class SchedulePage
{
    public function __invoke()
    {
        $schedules = ScheduleResource::collection(
            Schedule::with(['sportsSub', 'venue'])->latest()->get()
        )->resolve(); // jadi array

        return view('match.page.matchschedule', [
            'title' => 'Data Pertandingan',
            'section' => 'matchmaking',
            'selectedSection' => 'table',
            'table' => true,
            'schedules' => $schedules,
        ]);
    }

    public function scheduleInsert() {
        return view('match.form.register_match', [
            'title' => 'Buat Jadwal Pertandingan',
            'section'   => 'schedule',
            'selectedSection' => 'form',
            'form'  => true,

            // Tambahkan data lain jika perlu
        ]);
    }
}
