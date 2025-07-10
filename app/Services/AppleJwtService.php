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

    public function generateJwt(): string|null
    {
        $keyPath = config('services.apple.private_key_path');


        $privateKey = file_get_contents(storage_path($keyPath));  
        // $privateKey = Storage::get($keyPath);

        $now = time();
        $jwt = JWT::encode(
            [
                'iss' => config('services.apple.issuer_id'),
                'iat' => $now,
                'exp' => $now + 1200,                // 20 minutes
                'aud' => 'appstoreconnect-v1',
                'bid' => config('services.apple.client_id'), // <— Server-API spec
            ],
            $privateKey,
            'ES256',
            config('services.apple.key_id')
        );

        return $jwt;
    }

    public function verifyTransaction(string $originalTransactionId)
    {
        $jwt = $this->generateJwt();
     
        $baseUrl = config('services.apple.url');  // sandbox or production
        $url = "{$baseUrl}/inApps/v1/transactions/{$originalTransactionId}";

        // Make the HTTP POST request using Laravel HTTP Client
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$jwt}",
            'Content-Type' => 'application/json',
        ])->get($url);

        dd($response);

        if ($response->status() !== 200) {
            return false;
        }

        // Return the response body as an array
        return $response->json();

        //         try {

        // } catch (\Throwable $th) {
        //     Log::info('API Response:', ['body' => $th->getMessage()]);

        //     throw $th;
        // }
    }
}
