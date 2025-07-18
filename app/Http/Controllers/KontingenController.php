<?php

namespace App\Http\Controllers;

use App\Models\Kontingen;
use Illuminate\Http\Request;
use App\Http\Resources\KontingenResource;

class KontingenController extends Controller
{
    public function kontingenRegister() {
        $kontingens = Kontingen::with('regency')->get();
        return KontingenResource::collection($kontingens);
    }

    public function index()
    {
        $kontingens = Kontingen::with('regency')->get();
        return KontingenResource::collection($kontingens);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'province_id' => 'required|integer',
            'regencies_id' => 'required|integer',
        ]);

        $kontingen = Kontingen::create($data);
        return new KontingenResource($kontingen);
    }

    public function show($id)
    {
        return new KontingenResource(Kontingen::with('athletes')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kontingen = Kontingen::findOrFail($id);
        $kontingen->update($request->all());
        return new KontingenResource($kontingen);
    }

    public function destroy($id)
    {
        $kontingen = Kontingen::findOrFail($id);
        $kontingen->delete();
        return response()->noContent();
    }
}
