<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProbabilityResource;
use App\Models\Probability;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProbabilityController extends Controller
{
    public function index()
    {
        $probabilities = Probability::orderBy('label', 'asc')->get();
        return ProbabilityResource::collection($probabilities);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:50|unique:probability,label',
            'description' => 'nullable|string|max:255',
        ]);

        $probability = Probability::create([
            'id' => Str::uuid(),
            'label' => $data['label'],
            'description' => $data['description'] ?? null,
        ]);

        return new ProbabilityResource($probability);
    }

    public function show($id)
    {
        $probability = Probability::findOrFail($id);
        return new ProbabilityResource($probability);
    }

    public function update(Request $request, $id)
    {
        $probability = Probability::findOrFail($id);

        $data = $request->validate([
            'label' => 'required|string|max:50|unique:probability,label,' . $probability->id,
            'description' => 'nullable|string|max:255',
        ]);

        $probability->update($data);

        return new ProbabilityResource($probability);
    }

    public function destroy($id)
    {
        $probability = Probability::findOrFail($id);

        // Optional: Validasi apakah probability masih digunakan
        $hasPeople = $probability->people()->exists();
        if ($hasPeople) {
            return response()->json([
                'message' => 'Data tidak dapat dihapus karena masih digunakan oleh orang.',
            ], 400);
        }

        $probability->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
