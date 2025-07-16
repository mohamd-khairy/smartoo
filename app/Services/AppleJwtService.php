<?php

namespace App\Services;

use App\Models\Subscription;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class AppleJwtService
{
    protected $privateKey;
    protected $issuerId;
    protected $teamId;
    protected $keyId;
    protected $clientId;

    public function __construct()
    {
        $this->privateKey = config('services.apple.private_key_path');
        $this->issuerId = config('services.apple.issuer_id');
        $this->teamId = config('services.apple.team_id');
        $this->keyId = config('services.apple.key_id');
        $this->clientId = config('services.apple.client_id');
    }

    public function generateJwt(): string|null
    {
        try {

            $privateKey = file_get_contents(storage_path($this->privateKey));

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

        } catch (\Throwable $th) {
            return null;
        }
    }

    public function verifyTransaction(string $originalTransactionId, $envType = null)
    {
        try {
            $envType = $envType ?? config('services.apple.env_type');

            $jwt = $this->generateJwt();

            if (!$jwt)
                return false;

            $baseUrl = $envType == 'Sandbox' ? config('services.apple.sandbox_url') : config('services.apple.production_url');

            $url = "{$baseUrl}/inApps/v1/transactions/{$originalTransactionId}";

            // Make the HTTP POST request using Laravel HTTP Client
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$jwt}",
            ])->get($url);


            if ($response->status() !== 200) {
                return false;
            }

            $body = $response->json();

            if (empty($body['signedTransactionInfo'])) {
                return false;
            }

            $jws = $body['signedTransactionInfo'];
            $parts = explode('.', $jws);

            if (count($parts) !== 3) {
                return false;
            }

            $payload = $parts[1];
            $paddedPayload = str_pad($payload, (4 - strlen($payload) % 4) % 4 + strlen($payload), '=', STR_PAD_RIGHT);
            $json = base64_decode(strtr($paddedPayload, '-_', '+/'));
            $data = json_decode($json, true);

            $expiresDateMs = $data['expiresDate'] ?? null; // milliseconds
            $isActive = false;

            if ($expiresDateMs) {
                $nowMs = (int) (microtime(true) * 1000);
                $isActive = ($expiresDateMs > $nowMs);
            }

            // Properly add new keys to the response
            $data = array_merge($data, [
                'expiresDate' => $expiresDateMs,
                'expiresAt' => $expiresDateMs ? date('Y-m-d H:i:s', $expiresDateMs / 1000) : null,
                'isActive' => $isActive,
            ]);

            return $data;

        } catch (\Throwable $th) {
            info('error in verify transaction: ' . $th->getMessage());

            throw $th;
            // return false;
        }
    }

    public function verifyWebhook($request)
    {
        try {
            if (!$request->signedPayload) {
                return false;
            }

            $jws = $request->signedPayload;
            $parts = explode('.', $jws);

            if (count($parts) !== 3) {
                return false;
            }

            $payload = $parts[1];
            $paddedPayload = str_pad($payload, (4 - strlen($payload) % 4) % 4 + strlen($payload), '=', STR_PAD_RIGHT);
            $json = base64_decode(strtr($paddedPayload, '-_', '+/'));
            $data = json_decode($json, true);

            $expiresDateMs = $data['expiresDate'] ?? null; // milliseconds
            $isActive = false;

            if ($expiresDateMs) {
                $nowMs = (int) (microtime(true) * 1000);
                $isActive = ($expiresDateMs > $nowMs);
            }

            // Properly add new keys to the response
            $data = array_merge($data, [
                'expiresDate' => $expiresDateMs,
                'expiresAt' => $expiresDateMs ? date('Y-m-d H:i:s', $expiresDateMs / 1000) : null,
                'isActive' => $isActive,
            ]);

            info('API Response Webhook From Apple:', $data);
            //

            return $data;
        } catch (\Throwable $th) {
            info('Error from webhook: ' . $th->getMessage());

            throw $th;
            // return false;
        }
    }
}
