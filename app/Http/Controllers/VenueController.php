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
        ]);

        $venue = Venue::create($data);

        return new VenueResource($venue);
    }

    public function show(Venue $venue)
    {
        return new VenueResource($venue);
    }

    public function update(Request $request, Venue $venue)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'location' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'status' => 'sometimes|in:active,inactive',
            'user_id' => 'nullable|uuid',
        ]);

        $venue->update($data);

        return new VenueResource($venue);
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return response()->noContent();
    }
}
