<?php

namespace App\Http\Controllers;

use App\Models\SeriesGroupMatchSpecial;
use App\Http\Resources\SeriesGroupMatchSpecialResource;
use Illuminate\Http\Request;

class SeriesGroupMatchSpecialController extends Controller
{
    public function index()
    {
        $data = SeriesGroupMatchSpecial::with(['sport', 'kontingen'])->paginate(10);
        return SeriesGroupMatchSpecialResource::collection($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kontingenId' => 'required|exists:kontingens,id',
            'sports_subs_id' => 'required|uuid',
            'sportId' => 'required|exists:sports,id',
            'group' => 'nullable|string',
        ]);

        $seriesGroupMatchSpecial = SeriesGroupMatchSpecial::create($validated);

        return new SeriesGroupMatchSpecialResource($seriesGroupMatchSpecial->load(['sport', 'kontingen']));
    }

    public function show($id)
    {
        $seriesGroupMatchSpecial = SeriesGroupMatchSpecial::with(['sport', 'kontingen'])->findOrFail($id);

        return new SeriesGroupMatchSpecialResource($seriesGroupMatchSpecial);
    }

    public function update(Request $request, $id)
    {
        $seriesGroupMatchSpecial = SeriesGroupMatchSpecial::findOrFail($id);

        $validated = $request->validate([
            'kontingenId' => 'sometimes|exists:kontingens,id',
            'sports_subs_id' => 'sometimes|uuid',
            'sportId' => 'sometimes|exists:sports,id',
            'group' => 'nullable|string',
        ]);

        $seriesGroupMatchSpecial->update($validated);

        return new SeriesGroupMatchSpecialResource($seriesGroupMatchSpecial->load(['sport', 'kontingen']));
    }

    public function destroy($id)
    {
        $seriesGroupMatchSpecial = SeriesGroupMatchSpecial::findOrFail($id);
        $seriesGroupMatchSpecial->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
