<?php

namespace App\Http\Controllers;

use \Log;
use App\Models\SportsSub;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SportsSubController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        try {
            $subSport = SportsSub::create([
                'id' => Str::uuid(), // Pastikan menggunakan UUID
                'sportId' => $validated['sportId'],
                'name' => $validated['name'],
                // 'label' => $validated['label'] ?? null,
                // 'user_id' => null // Atau pakai: auth()->id() ?? null
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan.',
                'data' => $subSport
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $subSport = SportsSub::findOrFail($id);

        try {
            $subSport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kelas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'sportId' => ['required', 'uuid', Rule::exists('sports', 'id')],
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sports_subs')->where(function ($query) use ($request) {
                    return $query->where('sportId', $request->sportId);
                })
            ],
            'label' => ['nullable', 'string', 'max:100'] // diubah dari required → nullable
        ], [
            'sportId.required' => 'Cabang olahraga wajib dipilih.',
            'name.required' => 'Nama kelas wajib diisi.',
            'name.unique' => 'Kelas dengan nama ini sudah ada untuk cabor ini.',
        ]);
    }
}
