<?php

namespace App\Http\Pages;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Support\Facades\View;

class AtletPage
{
    public function __invoke()
    {
        $people = PersonResource::collection(
            Person::with([
                'province',
                'regencie',
                'district',
                'village',
                'kontingen',
                'document',
                'probability'
            ])
                ->whereNotNull('height')
                ->whereNotNull('weight')
                ->whereHas('probability', function ($query) {
                    $query->where('label', 'ATLET');
                })
                ->get()
        )->resolve(); // ⬅⬅ Ini yang bikin jadi array

        // dd($people);
        return view('atlet.page.atlet', [
            'title' => 'Data Atlet',
            'section' => 'atlet',
            'selectedSection' => 'table',
            'table' => true,
            'people' => $people,
        ]);
    }

    function atletForm() {
        return view('atlet.form.insert_atlet', [
            'title' => 'daftarkan atlet',
            'section'   => 'atlet',
            'selectedSection' => 'form',
            'form'  => true,

            // Tambahkan data lain jika perlu
        ]);
    }

    function atletFormEdit($id) {
        $person = Person::with([
            'province',
            'regencie',
            'district',
            'village',
            'kontingen',
            'document',
        ])->findOrFail($id);

        return view('atlet.form.update_atlet', [
            'title' => 'Edit Data Atlet',
            'section' => 'atlet',
            'selectedSection' => 'form',
            'form' => true,
            'person' => (new PersonResource($person))->forEdit(),
        ]);
    }

    function atletDetail($id)
    {
        $person = Person::with([
            'province',
            'regencie',
            'district',
            'village',
            'kontingen',
            'document',
            'athletes.sportsSub.sport'
        ])->findOrFail($id);

        return view('atlet.page.atlet_detail', [
            'title' => '[BIODATA] ',
            'section' => 'atlet',
            'selectedSection' => 'table',
            'table' => true,
            'person' => (new PersonResource($person))->resolve(),
            'kontingen' => $person->kontingen ?? '',
        ]);
    }
}
