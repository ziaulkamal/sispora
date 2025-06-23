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
                'document'
            ])
                ->whereNotNull('height')
                ->whereNotNull('weight')
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
            'document'
        ])->findOrFail($id);

        return view('atlet.form.update_atlet', [
            'title' => 'Edit Data Atlet',
            'section' => 'atlet',
            'selectedSection' => 'form',
            'form' => true,
            'person' => (new PersonResource($person))->forEdit(),
        ]);
    }
}
