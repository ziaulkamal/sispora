<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentResource;

class DocumentController extends Controller
{
    public function index()
    {
        return DocumentResource::collection(Document::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peopleId' => 'required|uuid|exists:people,id',
            'imageProfile' => 'nullable|string',
            'familyProfile' => 'nullable|string',
            'selfieProfile' => 'nullable|string',
            'path' => 'nullable|string',
            'imageId' => 'nullable|uuid',
            'extra' => 'nullable|json',
            'userId' => 'nullable|uuid',
        ]);

        $document = Document::create($data);
        return new DocumentResource($document);
    }

    public function show($id)
    {
        return new DocumentResource(Document::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->update($request->all());
        return new DocumentResource($document);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return response()->noContent();
    }
}