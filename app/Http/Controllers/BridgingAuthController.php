<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Services\BridgingAuthService;
use App\Models\AccessToken;
use Illuminate\Http\JsonResponse;

class BridgingAuthController extends Controller
{
    protected $authService;

    public function __construct(BridgingAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getToken(): JsonResponse
    {
        $latestToken = AccessToken::latest()->first();

        if ($latestToken && Carbon::parse($latestToken->created_at)->addMinutes(30)->isFuture()) {
            // Token masih berlaku
            return response()->json([
                'token' => $latestToken->token,
                'status' => 'existing'
            ]);
        }

        // Token expired atau belum ada, ambil token baru
        try {
            $response = $this->authService->getAccessToken();
            $newToken = $response['access_token'] ?? null;

            if (!$newToken) {
                return response()->json(['error' => 'Token not found in response'], 500);
            }

            // Simpan token ke database
            AccessToken::create([
                'token' => $newToken,
                'created_at' => now(),
            ]);

            return response()->json([
                'token' => $newToken,
                'status' => 'new'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
