<?php

namespace App\Http\Controllers;

use App\Models\AdditionalScheduleRegular;
use App\Http\Resources\AdditionalScheduleRegularResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdditionalScheduleRegularController extends Controller
{
    public function index()
    {
        return AdditionalScheduleRegularResource::collection(
            AdditionalScheduleRegular::latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedulesId' => 'required|uuid|exists:schedules,id',
            'kontingenId' => 'required|uuid|exists:kontingens,id',
            'typeScore' => 'in:minutes,weight,distance,default',
            'score' => 'nullable|string',
            'status' => 'in:win,lose,default'
        ]);

        $data['id'] = Str::uuid();

        $item = AdditionalScheduleRegular::create($data);

        return new AdditionalScheduleRegularResource($item);
    }

    public function show($id)
    {
        $item = AdditionalScheduleRegular::findOrFail($id);
        return new AdditionalScheduleRegularResource($item);
    }

    public function update(Request $request, $id)
    {
        $item = AdditionalScheduleRegular::findOrFail($id);

        $data = $request->validate([
            'schedulesId' => 'sometimes|uuid|exists:schedules,id',
            'kontingenId' => 'sometimes|uuid|exists:kontingens,id',
            'typeScore' => 'in:minutes,weight,distance,default',
            'score' => 'nullable|string',
            'status' => 'in:win,lose,default'
        ]);

        $item->update($data);

        return new AdditionalScheduleRegularResource($item);
    }

    public function destroy($id)
    {
        $item = AdditionalScheduleRegular::findOrFail($id);
        $item->delete();

        return response()->noContent();
    }
}
