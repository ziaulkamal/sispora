<?php

namespace App\Http\Pages;

use App\Http\Resources\SportResource;
use App\Models\Sport;
use Illuminate\Support\Facades\View;

class SportPage
{
    public function __invoke()
    {
        $sports = Sport::with('subSports')->get(); // Eager load subSports

        return view('sport.index', [
            'title' => 'Data Cabang Olahraga',
            'section' => 'Cabang Olahraga',
            'selectedSection' => 'table',
            'table' => true,
            'sport' => SportResource::collection($sports)->resolve(),
        ]);
    }

    public function sportForm() {
        return view('sport.insert_sport', [
            'title' => 'Data Cabang Olahraga',
            'section' => 'Cabang Olahraga',
            'selectedSection' => 'form',
            'form'  => true,

        ]);
    }

    public function updateSportForm($id)
    {
        $sports = Sport::findOrFail($id);
        return view('sport.update_sport', [
            'title' => 'Data Cabang Olahraga',
            'section' => 'Cabang Olahraga',
            'selectedSection' => 'form',
            'form'  => true,
            'sport' => $sports,
        ]);
    }

    public function subsportdata($id) {

        $sports = Sport::with('subSports')->findOrFail($id);
        return view('sport.subsports', [
            'title' => 'Data Cabang Kelas Olahraga',
            'section' => 'Cabang Kelas Olahraga',
            'selectedSection' => 'table',
            'table' => true,
            'sport' => $sports,
        ]);
    }
}
