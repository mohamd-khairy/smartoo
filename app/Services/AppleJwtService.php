<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AppleJwtService
{
    protected $privateKey;
    protected $issuerId;
    protected $teamId;
    protected $keyId;
    protected $clientId;

    public function __construct()
    {
        $this->privateKey = Storage::get(config('services.apple.private_key_path')); //file_get_contents(storage_path(config('services.apple.private_key_path')));
        $this->issuerId = config('services.apple.issuer_id');
        $this->teamId = config('services.apple.team_id');
        $this->keyId = config('services.apple.key_id');
        $this->clientId = config('services.apple.client_id');
    }

    public function generateJwt()
    {
        try {
            // JWT payload
            $issuedAt = time();
            $expirationTime = $issuedAt + 600; // JWT is valid for 10 minutes

            $payload = [
                'iss' => $this->issuerId,
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'aud' => "appstoreconnect-v1",
                'sub' => $this->clientId,
            ];

            // Encode the JWT using the private key and ES256 algorithm
            $jwt = JWT::encode($payload, $this->privateKey, 'ES256', $this->keyId);

            return $jwt;
        } catch (\Exception $e) {
            Log::error('Error generating JWT: ' . $e->getMessage());
            return null;
        }
    }

    public function verifyTransaction(string $originalTransactionId)
    {
        try {
            $jwt = $this->generateJwt();
            dd($jwt);

            info('JWT: ' . $jwt);
            $baseUrl = config('services.apple.url');  // sandbox or production
            $url = "{$baseUrl}/inApps/v1/transactions/{$originalTransactionId}";

            // Make the HTTP POST request using Laravel HTTP Client
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$jwt}",
                'Content-Type' => 'application/json',
            ])->post($url);

            dd($response);

            // Log the response status code and body for debugging
            Log::info('API Response:', ['status_code' => $response->status(), 'body' => $response->body()]);

            if ($response->status() !== 200) {
                return false;
            }

            // Return the response body as an array
            return $response->json();

            // return  json_decode($response->getBody()->getContents(), true);
            //code...
        } catch (\Throwable $th) {
            Log::info('API Response:', ['body' => $th->getMessage()]);

            throw $th;
        }
    }
}
