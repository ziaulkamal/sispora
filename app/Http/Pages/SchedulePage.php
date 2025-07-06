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
            Schedule::with(['sportsSub.sport', 'venue'])->latest()->get()
        )->resolve(); // jadi array
        // dd($schedules);

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

    public function seriesSports() {
        return view('match.form.register_series', [
            'title' => 'Group Pertandingan (Khusus)',
            'section'   => 'groups',
            'selectedSection' => 'form',
            'form'  => true,

            // Tambahkan data lain jika perlu
        ]);
    }

    public function makeSeriesSports() {
        return view('match.form.register_series', [
            'title' => 'Group Pertandingan (Khusus)',
            'section'   => 'groups',
            'selectedSection' => 'form',
            'form'  => true,

            // Tambahkan data lain jika perlu
        ]);
    }

    public function scheduleDetail($id) {
        $schedule = Schedule::findOrFail($id);
        $schedule->load(['sportsSub.sport', 'venue']);
        $case = $schedule->sportsSub?->sport?->specialCase;

        // Default 'no' jika tidak 'yes'
        $case = $case === 'yes' ? 'yes' : 'no';

        // Load relasi tambahan sesuai specialCase
        if ($case === 'yes') {
            $schedule->load(['additionalSchedulesSpecial.kontingen.regency']);
        } else {
            $schedule->load(['additionalSchedulesRegular.kontingen.regency']);
        }

        return view('match.form.detail_match', [
            'title' => 'Jadwal Pertandingan Detail',
            'section'   => 'schedule',
            'selectedSection' => 'form',
            'form'  => true,
            'schedule' => (new ScheduleResource($schedule))->resolve(),
        ]);
    }

    public function scheduleUpdate($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->load(['sportsSub.sport', 'venue']);
        $case = $schedule->sportsSub?->sport?->specialCase;

        // Default 'no' jika tidak 'yes'
        $case = $case === 'yes' ? 'yes' : 'no';

        // Load relasi tambahan sesuai specialCase
        if ($case === 'yes') {
            $schedule->load(['additionalSchedulesSpecial.kontingen.regency']);
        } else {
            $schedule->load(['additionalSchedulesRegular.kontingen.regency']);
        }

        return view('match.form.detail_match_update', [
            'title' => 'Update Hasil Pertandingan',
            'section'   => 'schedule',
            'selectedSection' => 'form',
            'form'  => true,
            'schedule' => (new ScheduleResource($schedule))->resolve(),
        ]);

    }
}
