<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['sportsSub', 'venue'])->latest()->get();
        return ScheduleResource::collection($schedules);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i:s',
            'end_time'      => 'required|date_format:H:i:s',
            'sports_sub_id' => 'required|exists:sports_subs,id',
            'venue_id'      => 'required|exists:venues,id',
            'status'        => 'required|in:active,inactive',
            'user_id'       => 'nullable|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule = Schedule::create($validator->validated());

        return new ScheduleResource($schedule->load(['sportsSub', 'venue']));
    }

    public function show(Schedule $schedule)
    {
        return new ScheduleResource($schedule->load(['sportsSub', 'venue']));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'date'          => 'sometimes|date',
            'start_time'    => 'sometimes|date_format:H:i:s',
            'end_time'      => 'sometimes|date_format:H:i:s',
            'sports_sub_id' => 'sometimes|exists:sports_subs,id',
            'venue_id'      => 'sometimes|exists:venues,id',
            'status'        => 'sometimes|in:active,inactive',
            'user_id'       => 'nullable|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule->update($validator->validated());

        return new ScheduleResource($schedule->load(['sportsSub', 'venue']));
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully.']);
    }
}
