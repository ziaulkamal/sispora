<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use App\Http\Resources\AthleteResource;

class AthleteController extends Controller
{
    public function index()
    {
        return AthleteResource::collection(Athlete::with(['person', 'kontingen'])->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peopleId' => 'required|uuid|exists:people,id',
            'sportsSubId' => 'required|uuid',
        ]);

        $exists = Athlete::where('peopleId', $data['peopleId'])
            ->where('sportsSubId', $data['sportsSubId'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Atlet ini sudah terdaftar di kelas cabang olahraga tersebut.'
            ], 422);
        }

        $athlete = Athlete::create($data);
        return new AthleteResource($athlete);
    }

    public function show($id)
    {
        return new AthleteResource(Athlete::with(['person', 'kontingen'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $athlete = Athlete::findOrFail($id);
        $athlete->update($request->all());
        return new AthleteResource($athlete);
    }

    public function destroy($id)
    {
        Athlete::findOrFail($id)->delete();
        return response()->noContent();
    }
}
