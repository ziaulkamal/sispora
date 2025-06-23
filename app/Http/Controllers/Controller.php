<?php

namespace App\Http\Controllers;

use App\Services\BridgingAuthService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request; // Fix: gunakan Illuminate\Http\Request, bukan Facades\Request

class Controller
{
    protected $authService;

    public function __construct(BridgingAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getIdentityPeople($nik)
    {
        try {
            $accessToken = $this->authService->getAccessToken(); // Token langsung didapat dari service

            $client = new Client();
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ];

            $baseUrl = env('SATUSEHAT_BASE_URL');
            $url = "{$baseUrl}/fhir-r4/v1/Patient?identifier=https://fhir.kemkes.go.id/id/nik|{$nik}";

            $response = $client->get($url, [
                'headers' => $headers,
                'verify' => false,
            ]);

            $patientData = json_decode($response->getBody(), true);

            if (!empty($patientData['entry']) && isset($patientData['entry'][0]['resource'])) {
                $resource = $patientData['entry'][0]['resource'];

                $formattedData = [
                    'id' => $resource['id'],
                    'name' => $resource['name'][0]['text'] ?? null,
                ];

                return response()->json($formattedData);
            }

            return response()->json(['error' => 'No data found'], 404);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function getIdentityPeopleByAttribute(Request $request)
    {
        try {
            $name = $request->query('name');
            $nik = $request->query('nik');

            if (!$name || !$nik) {
                return response()->json([
                    'error' => 'Missing required parameters',
                    'message' => 'Please provide name and nik.',
                ], 400);
            }

            $birthdate = $this->extractBirthdateFromNik($nik);
            if (!$birthdate) {
                return response()->json([
                    'error' => 'Invalid NIK format',
                    'message' => 'Unable to extract birthdate from NIK.',
                ], 400);
            }

            $accessToken = $this->authService->getAccessToken();

            $client = new Client();
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ];

            $baseUrl = env('SATUSEHAT_BASE_URL');
            $encodedName = urlencode($name);
            $identifierParam = "https://fhir.kemkes.go.id/id/nik|{$nik}";
            $url = "{$baseUrl}/fhir-r4/v1/Patient?name={$encodedName}&birthdate={$birthdate}&identifier={$identifierParam}";

            $response = $client->get($url, [
                'headers' => $headers,
                'verify' => false,
            ]);

            $patientData = json_decode($response->getBody(), true);
            // dd($patientData);
            if (!empty($patientData['entry'][0]['resource'])) {
                $resource = $patientData['entry'][0]['resource'];

                $address = $resource['address'][0] ?? [];
                $extensions = $address['extension'][0]['extension'] ?? [];

                $adminCodes = [];
                foreach ($extensions as $ext) {
                    $adminCodes[$ext['url']] = $ext['valueCode'];
                }

                $formattedData = [
                    'id' => $resource['id'] ?? null,
                    'name' => $resource['name'][0]['text'] ?? null,
                    'birthDate' => date('m/d/Y', strtotime($resource['birthDate'] ?? '')),
                    'gender' => $resource['gender'] ?? null,
                    'province' => $adminCodes['province'] ?? null,
                    'regency' => $adminCodes['city'] ?? null,
                    'district' => $adminCodes['district'] ?? null,
                    'village' => $adminCodes['village'] ?? null,
                    'line' => $address['line'][0] ?? null,
                ];

                return response()->json($formattedData);
            }

            return response()->json(['error' => 'No data found'], 404);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }


    private function extractBirthdateFromNik(string $nik): ?string
    {
        if (strlen($nik) < 12) return null;

        $day = intval(substr($nik, 6, 2));
        $month = intval(substr($nik, 8, 2));
        $year = intval(substr($nik, 10, 2));

        if ($day > 40) $day -= 40; // Perempuan
        $fullYear = $year <= 25 ? 2000 + $year : 1900 + $year;

        return sprintf('%04d-%02d-%02d', $fullYear, $month, $day);
    }
}
