<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentResource;

class DocumentController extends Controller
{
    public function index()
    {
        return DocumentResource::collection(Document::with('person')->get());
    }

    public function show($id)
    {
        return new DocumentResource(Document::with('person')->findOrFail($id));
    }

    public function uploadDocument(Request $request, $peopleId)
    {
        // Ambil document berdasarkan peopleId (karena ini foreign key)
        $document = Document::where('peopleId', $peopleId)->first();

        if (!$document) {
            $document = Document::create([
                'peopleId' => $peopleId,
            ]);
        }

        // Validasi field yang diperbolehkan
        $field = $request->input('field');
        $validFields = [
            'imageProfile',
            'identityProfile',
            'familyProfile',
            'personalCertificate',
            'lastDiploma',
            'supportPdf'
        ];

        if (!in_array($field, $validFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Field tidak valid. Mohon coba lagi.'
            ], 400);
        }

        // Validasi file dengan pesan bahasa Indonesia
        $rules = [
            'file' => ($field === 'supportPdf')
                ? 'required|mimes:pdf|max:2048'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'file.required' => 'Silakan unggah file terlebih dahulu.',
            'file.mimes' => $field === 'supportPdf'
                ? 'Format file harus PDF.'
                : 'Format file harus berupa JPG, JPEG, PNG, atau WEBP.',
            'file.image' => 'File harus berupa gambar.',
            'file.max' => 'Ukuran file maksimal 2 MB.',
        ];

        $request->validate($rules, $messages);

        try {
            // Buat hashed folder
            $hashFolder = md5($peopleId) . sha1($peopleId);
            $filePath = $request->file('file')->store("documents/{$hashFolder}", 'public');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah file: ' . $e->getMessage()
            ], 500);
        }

        // Update kolom terkait
        $document->{$field} = $filePath;
        $document->{$field . '_status'} = 'pending';
        $document->{$field . '_note'} = null;
        $document->save();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diunggah. Dokumen akan segera diperiksa.',
            'path' => $filePath,
        ]);
    }





    // UPDATE berdasarkan peopleId (bukan id document)
    public function updateByPersonId(Request $request, $peopleId)
    {
        $document = Document::where('peopleId', $peopleId)->firstOrFail();

        $data = $request->validate([
            'imageProfile' => 'nullable|string',
            'imageProfile_status' => 'nullable|in:pending,approved,rejected',
            'imageProfile_note' => 'nullable|string',

            'identityProfile' => 'nullable|string',
            'identityProfile_status' => 'nullable|in:pending,approved,rejected',
            'identityProfile_note' => 'nullable|string',

            'familyProfile' => 'nullable|string',
            'familyProfile_status' => 'nullable|in:pending,approved,rejected',
            'familyProfile_note' => 'nullable|string',

            'personalCertificate' => 'nullable|string',
            'personalCertificate_status' => 'nullable|in:pending,approved,rejected',
            'personalCertificate_note' => 'nullable|string',

            'lastDiploma' => 'nullable|string',
            'lastDiploma_status' => 'nullable|in:pending,approved,rejected',
            'lastDiploma_note' => 'nullable|string',

            'supportPdf' => 'nullable|string',
            'supportPdf_status' => 'nullable|in:pending,approved,rejected',
            'supportPdf_note' => 'nullable|string',

            'userId' => 'nullable|uuid',
        ]);

        $document->update($data);

        return new DocumentResource($document);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return response()->noContent();
    }
}
