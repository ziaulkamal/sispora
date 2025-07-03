<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with(['people'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:1,2,3,4,5',
            'status' => 'required|in:active,inactive,banned',
            'people_id' => 'nullable|exists:people,id',
        ]);

        $user = User::create([
            'id' => (string) Str::uuid(),
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'people_id' => $validated['people_id'] ?? null,
        ]);

        return new UserResource($user);
    }

    public function show($id)
    {
        $user = User::with('people')->findOrFail($id);
        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|unique:users,username,' . $id,
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'sometimes|in:1,2,3,4,5',
            'status' => 'sometimes|in:active,inactive,banned',
            'people_id' => 'nullable|exists:people,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->username === 'masteradmin') {
            return response()->json(['message' => 'User master admin tidak dapat dihapus.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
