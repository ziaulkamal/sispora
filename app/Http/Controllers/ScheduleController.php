<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Models\AdditionalScheduleRegular;
use App\Models\AdditionalScheduleSpecial;
use App\Models\Schedule;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['sportsSub.sport', 'venue'])
            ->latest()
            ->get();

        return ScheduleResource::collection($schedules);
    }

    public function store(Request $request)
    {
        $sportsId = $request->input('mainSport');
        $matchedType = $request->input('match_type');
        $sportsValidation = Sport::findOrFail($sportsId);
        $schedulesValidation = Schedule::query()
            ->where('sportsSubId', $request->input('sportsSubId'))
            ->where('venuesId', $request->input('venuesId'))
            ->where('date', $request->input('date'))
            ->where('start_time', '=', $request->input('start_time'))
            ->where('end_time', '=', $request->input('end_time'));

        $validator = Validator::make($request->all(), [
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i:s',
            'end_time'      => 'required|date_format:H:i:s',
            'sportsSubId'   => 'required|exists:sports_subs,id',
            'venuesId'      => 'required|exists:venues,id',
            'status'        => 'required|in:active,inactive',
            'user_id'       => 'nullable|uuid',
        ], [
            'date.required'         => 'Tanggal wajib diisi.',
            'date.date'             => 'Format tanggal tidak valid.',
            'start_time.required'   => 'Waktu mulai wajib diisi.',
            'start_time.date_format' => 'Format waktu mulai harus H:i:s.',
            'end_time.required'     => 'Waktu selesai wajib diisi.',
            'end_time.date_format'  => 'Format waktu selesai harus H:i:s.',
            'sportsSubId.required'  => 'Kelas wajib dipilih.',
            'sportsSubId.exists'    => 'Kelas tidak ditemukan.',
            'venuesId.required'     => 'Venue wajib dipilih.',
            'venuesId.exists'       => 'Venue tidak ditemukan.',
            'status.required'       => 'Status wajib diisi.',
            'status.in'             => 'Status harus antara active atau inactive.',
            'user_id.uuid'          => 'User ID harus format UUID.'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if ($schedulesValidation->exists()) {
            return response()->json([
                'message' => 'Jadwal ini sudah ada pada tanggal, waktu, dan venue yang sama.'
            ], 423);
        }

        if ($sportsValidation->specialCase === 'yes') {
            if ($matchedType !== 'headtohead') {
                return response()->json([
                    'message' => 'Kondisi untuk pertandingan Bola harus ada 2 kontingen yang dipertandingkan dan harus Head To Head.'
                ], 424);
            }
        }

        $schedule = Schedule::create($validator->validated());
        if ($matchedType === 'headtohead') {
            for ($i=0; $i < collect($request->input('kontingens'))->count() ; $i++) {
                $data = [
                    'schedulesId' => $schedule->id,
                    'match' => 'qualified',
                    'kontingenId' => $request->input('kontingens')[$i],
                ];
                AdditionalScheduleSpecial::create($data);
            }
        }else {
            for ($i = 0; $i < collect($request->input('kontingens'))->count(); $i++) {
                $data = [
                    'schedulesId' => $schedule->id,
                    'kontingenId' => $request->input('kontingens')[$i],
                ];
                AdditionalScheduleRegular::create($data);
            }
        }

        return new ScheduleResource($schedule->load(['sportsSub', 'venue']));
    }

    public function show($id)
    {
        $schedule = Schedule::with(['sportsSub', 'venue'])->findOrFail($id);
        return new ScheduleResource($schedule);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date'          => 'sometimes|date',
            'start_time'    => 'sometimes|date_format:H:i:s',
            'end_time'      => 'sometimes|date_format:H:i:s',
            'sportsSubId'   => 'sometimes|exists:sports_subs,id',
            'venuesId'      => 'sometimes|exists:venues,id',
            'status'        => 'sometimes|in:active,inactive',
            'user_id'       => 'nullable|uuid',
        ], [
            'date.date'             => 'Format tanggal tidak valid.',
            'start_time.date_format' => 'Format waktu mulai harus H:i:s.',
            'end_time.date_format'  => 'Format waktu selesai harus H:i:s.',
            'sportsSubId.exists'    => 'Kelas tidak ditemukan.',
            'venuesId.exists'       => 'Venue tidak ditemukan.',
            'status.in'             => 'Status harus antara active atau inactive.',
            'user_id.uuid'          => 'User ID harus format UUID.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $schedule->update($validator->validated());

        return new ScheduleResource($schedule->load(['sportsSub', 'venue']));
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'message' => 'Jadwal berhasil dihapus.',
            'id'      => $schedule->id
        ]);
    }
}
