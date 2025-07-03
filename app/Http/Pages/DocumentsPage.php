<?php

namespace App\Http\Pages;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Support\Facades\View;

class DocumentsPage
{
    public function __invoke()
    {
        return View::make('pages.{{ view }}');
    }

    public function detail($peopleId) {
        $person = Person::with([
            'province',
            'regencie',
            'district',
            'village',
            'kontingen',
            'document',
        ])->findOrFail($peopleId);
        $document = $person->document; // Eager loaded

        return view('documents.form_atlet', [
            'title' => 'Dokumen Atlet ',
            'section' => 'dokumen',
            'selectedSection' => 'form',
            'form' => true,
            'person' => (new PersonResource($person))->forEdit(),
            'peopleId' => $peopleId,
            'document' => $document,
        ]);
    }
}
