<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Resources\SportResource;

class SportController extends Controller
{
    public function index()
    {
        return SportResource::collection(Sport::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'imageId' => 'nullable|uuid',
            'status' => 'required|in:active,inactive',
            'userId' => 'nullable|uuid',
        ]);

        $sport = Sport::create($data);
        return new SportResource($sport);
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
}
