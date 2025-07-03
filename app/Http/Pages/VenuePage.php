<?php

namespace App\Http\Pages;

use App\Http\Resources\VenueResource;
use App\Models\Venue;
use Illuminate\Support\Facades\View;

class VenuePage
{
    public function __invoke()
    {
        $venue = VenueResource::collection(Venue::latest()->get());

        return view('maps.venue', [
            'title' => 'Data Venue Tersedia',
            'section' => 'Data Venue',
            'selectedSection' => 'table',
            'table' => true,
            'venues' => $venue,
        ]);
    }

    public function insertVenue() {
        return view('maps.insert_venue', [
            'title' => 'Tambah Venue Baru',
            'section' => 'Venue',
            'selectedSection' => 'form',
            'form'  => true,
        ]);
    }
}
