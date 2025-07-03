<?php

namespace App\Http\Controllers;

use App\Models\AdditionalScheduleSpecial;
use App\Http\Resources\AdditionalScheduleSpecialResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdditionalScheduleSpecialController extends Controller
{
    public function index()
    {
        return AdditionalScheduleSpecialResource::collection(
            AdditionalScheduleSpecial::latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedulesId' => 'required|uuid|exists:schedules,id',
            'match' => 'required|in:qualified,group,grandfinal',
            'group' => 'nullable|string',
            'kontingenId' => 'required|uuid|exists:kontingens,id',
            'score' => 'nullable|string',
            'status' => 'in:win,lose,default'
        ]);

        $data['id'] = Str::uuid();

        $item = AdditionalScheduleSpecial::create($data);

        return new AdditionalScheduleSpecialResource($item);
    }

    public function show($id)
    {
        $item = AdditionalScheduleSpecial::findOrFail($id);
        return new AdditionalScheduleSpecialResource($item);
    }

    public function update(Request $request, $id)
    {
        $item = AdditionalScheduleSpecial::findOrFail($id);

        $data = $request->validate([
            'schedulesId' => 'sometimes|uuid|exists:schedules,id',
            'match' => 'sometimes|in:qualified,group,grandfinal',
            'group' => 'nullable|string',
            'kontingenId' => 'sometimes|uuid|exists:kontingens,id',
            'score' => 'nullable|string',
            'status' => 'in:win,lose,default'
        ]);

        $item->update($data);

        return new AdditionalScheduleSpecialResource($item);
    }

    public function destroy($id)
    {
        $item = AdditionalScheduleSpecial::findOrFail($id);
        $item->delete();

        return response()->noContent();
    }
}
