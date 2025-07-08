<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;

class AppleJwtService
{
    protected $privateKey;
    protected $issuerId;
    protected $keyId;

    public function __construct()
    {
        // Load the private key from the .p8 file
        $this->privateKey = file_get_contents(storage_path('app/apple/AuthKey_ABC123.p8')); // Replace with your .p8 path
        $this->issuerId = config('services.apple.issuer_id'); // Issuer ID from App Store Connect
        $this->keyId = config('services.apple.key_id'); // Key ID from App Store Connect
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
                'aud' => 'appstoreconnect-v1',
            ];

            // Encode the JWT using the private key and ES256 algorithm
            $jwt = JWT::encode($payload, $this->privateKey, 'ES256', $this->keyId);

            return $jwt;
        } catch (\Exception $e) {
            Log::error('Error generating JWT: ' . $e->getMessage());
            return null;
        }
    }

    public function verifyTransaction(string $signedTransaction)
    {
        try {

            $client = new \GuzzleHttp\Client([
                'base_uri' => config('services.apple.url'), // sandbox او production
            ]);

            $response = $client->get('/inApps/v1/transactions/', [
                'headers' => [
                    'Authorization' => "Bearer {$this->generateJwt()}",
                    'Content-Type' => 'application/json'
                ],
                'json' => ['signedTransactionInfo' => $signedTransaction]
            ]);

            return json_decode($response->getBody()->getContents(), true);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
