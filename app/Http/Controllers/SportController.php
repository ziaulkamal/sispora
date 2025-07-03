<?php

namespace App\Http\Controllers;

use App\Http\Resources\SportResource;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class SportController extends Controller
{
    public function index()
    {
        return SportResource::collection(Sport::orderBy('name', 'asc')->get());
    }

    public function store(Request $request)
    {
        $request->merge([
            'description' => $request->input('name'),
        ]);

        // Custom pesan validasi
        $messages = [
            'name.required' => 'Nama cabang olahraga wajib diisi.',
            'name.string' => 'Nama cabang olahraga harus berupa teks.',
            'name.unique' => 'Nama cabang olahraga sudah digunakan.',
            'description.unique' => 'Deskripsi cabang olahraga sudah digunakan.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus bernilai active atau inactive.',
        ];

        // Validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:sports,name',
            'description' => 'unique:sports,description',
            'imageId' => 'nullable|uuid',
            'status' => 'required|in:active,inactive',
            'userId' => 'nullable|uuid',
        ], $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Simpan
        $sport = Sport::create($validator->validated());

        return new SportResource($sport->fresh('subSports'));
    }

    public function show($id)
    {
        return new SportResource(Sport::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $sport = Sport::findOrFail($id);
        $sport->update($request->all());
        return new SportResource($sport);
    }

    public function destroy($id)
    {
        Sport::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function specialCase($id) {
        $sport = Sport::findOrFail($id);
        $sport->specialCase = 'yes';
        $sport->save();
        return response()->noContent();
    }
}
