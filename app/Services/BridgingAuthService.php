<?php

namespace App\Services;

use App\Models\AccessToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class BridgingAuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getAccessToken(): string
    {
        // Cek token valid
        $existingToken = AccessToken::where('expires_at', '>', Carbon::now())->first();

        if ($existingToken) {
            return $existingToken->token;
        }

        // Generate token baru
        $clientId = env('SATUSEHAT_CLIENT_ID');
        $clientSecret = env('SATUSEHAT_CLIENT_SECRET');
        $baseUrl = env('SATUSEHAT_BASE_URL');

        $url = "{$baseUrl}/oauth2/v1/accesstoken?grant_type=client_credentials";

        $options = [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]
        ];

        try {
            $request = new Request('POST', $url);
            $response = $this->client->sendAsync($request, $options)->wait();
            $data = json_decode($response->getBody(), true);

            $token = $data['access_token'] ?? null;
            $expiresIn = isset($data['expires_in']) ? (int) $data['expires_in'] : 1800;

            if (!$token) {
                throw new \Exception('Access token not found in response.');
            }

            // Simpan ke DB
            AccessToken::create([
                'token' => $token,
                'created_at' => now(),
                'expires_at' => now()->addSeconds($expiresIn),
            ]);

            return $token;
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorMessage = $errorResponse ? $errorResponse->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Failed to fetch access token: $errorMessage");
        }
    }
}
