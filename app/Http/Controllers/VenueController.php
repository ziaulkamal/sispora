<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Resources\VenueResource;

class VenueController extends Controller
{
    public function index()
    {
        return VenueResource::collection(Venue::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'user_id' => 'nullable|uuid',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'location.required' => 'Lokasi wajib diisi.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus bernilai active atau inactive.',
            'user_id.uuid' => 'User ID harus berupa UUID yang valid.',
        ]);

        $venue = Venue::create($data);

        return new VenueResource($venue);
    }

    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return new VenueResource($venue);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'location' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'status' => 'sometimes|in:active,inactive',
            'user_id' => 'nullable|uuid',
        ], [
            'name.string' => 'Nama harus berupa teks.',
            'location.string' => 'Lokasi harus berupa teks.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'status.in' => 'Status harus bernilai active atau inactive.',
            'user_id.uuid' => 'User ID harus berupa UUID yang valid.',
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($data);

        return new VenueResource($venue);
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);

        if ($venue->schedules()->exists()) {
            return response()->json([
                'message' => 'Venue tidak bisa dihapus karena sudah didaftarkan ke dalam jadwal.'
            ], 400);
        }

        $venue->delete();

        return response()->json([
            'message' => 'Venue berhasil dihapus.'
        ]);
    }
}
