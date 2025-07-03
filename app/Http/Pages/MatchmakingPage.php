<?php

namespace App\Http\Pages;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Support\Facades\View;

class MatchmakingPage
{
    public function __invoke()
    {
        return view('match.form.register_match', [
            'title' => 'daftarkan atlet',
            'section'   => 'atlet',
            'selectedSection' => 'form',
            'form'  => true,

            // Tambahkan data lain jika perlu
        ]);
    }


}
