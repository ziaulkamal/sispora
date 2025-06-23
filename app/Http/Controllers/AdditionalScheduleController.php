<?php

namespace App\Http\Controllers;

use App\Models\AdditionalSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdditionalScheduleResource;

class AdditionalScheduleController extends Controller
{
    public function index()
    {
        $data = AdditionalSchedule::with(['schedule', 'kontingen'])->latest()->get();
        return AdditionalScheduleResource::collection($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'  => 'required|exists:schedules,id',
            'match'        => 'required|in:qualified,bye,BO4,grandfinal,final',
            'kontingen_id' => 'required|exists:kontingens,id',
            'status'       => 'required|in:true,false',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = AdditionalSchedule::create($validator->validated());

        return new AdditionalScheduleResource($data->load(['schedule', 'kontingen']));
    }

    public function show(AdditionalSchedule $additionalSchedule)
    {
        return new AdditionalScheduleResource($additionalSchedule->load(['schedule', 'kontingen']));
    }

    public function update(Request $request, AdditionalSchedule $additionalSchedule)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'  => 'sometimes|exists:schedules,id',
            'match'        => 'sometimes|in:qualified,bye,BO4,grandfinal,final',
            'kontingen_id' => 'sometimes|exists:kontingens,id',
            'status'       => 'sometimes|in:true,false',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $additionalSchedule->update($validator->validated());

        return new AdditionalScheduleResource($additionalSchedule->load(['schedule', 'kontingen']));
    }

    public function destroy(AdditionalSchedule $additionalSchedule)
    {
        $additionalSchedule->delete();
        return response()->json(['message' => 'Additional Schedule deleted successfully.']);
    }
}
