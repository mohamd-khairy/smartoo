<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;

class AppleJwtService
{
    protected $privateKey;
    protected $teamId;
    protected $keyId;
    protected $clientId;

    public function __construct()
    {
        $this->privateKey = file_get_contents(storage_path(config('services.apple.private_key_path')));
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
                'iss' => $this->teamId,
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'aud' => 'https://appleid.apple.com',
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

            $client = new \GuzzleHttp\Client([
                'base_uri' => config('services.apple.url'), // sandbox او production
            ]);


            $response = $client->get("/inApps/v1/transactions/{$originalTransactionId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->generateJwt()}",
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
