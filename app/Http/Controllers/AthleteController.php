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
            'kontingenId' => 'required|uuid|exists:kontingens,id',
            'sportsSubId' => 'required|uuid',
        ]);

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
