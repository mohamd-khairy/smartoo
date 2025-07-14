<?php

use App\Services\AppleJwtService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('/', 'welcome');
Route::view('/swagger-ui', 'swagger');
Route::get('/swagger-docs', function () {

    $path = 'scribe/openapi.yaml'; // relative to storage/app/private

    if (!Storage::disk('private')->exists($path)) {
        abort(404, 'Swagger file not found.');
    }

    return response(Storage::disk('private')->get($path), 200, [
        'Content-Type' => 'application/yaml',
    ]);
});


Route::get('/scribe/{transactionId}', function ($transactionId) {
    $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/transactions/{$transactionId}";
    $jwt = (new AppleJwtService())->generateJwt();

    $headers = [
        'Authorization' => "Bearer {$jwt}",
        'Accept' => 'application/json',
    ];

    $response = Http::withHeaders($headers)->get($url);

    if (!$response->ok()) {
        // Optionally dd($response->json()) for Apple error details
        abort($response->status(), 'Apple API Error: ' . json_encode($response->json()));
    }

    $body = $response->json();

    if (empty($body['signedTransactionInfo'])) {
        abort(500, 'No signedTransactionInfo found in response.');
    }

    $jws = $body['signedTransactionInfo'];
    $parts = explode('.', $jws);

    if (count($parts) !== 3) {
        abort(500, 'Malformed JWS!');
    }

    // Decode payload (the second part)
    $payload = $parts[1];
    // Pad base64url as needed
    $paddedPayload = str_pad($payload, (4 - strlen($payload) % 4) % 4 + strlen($payload), '=', STR_PAD_RIGHT);
    $json = base64_decode(strtr($paddedPayload, '-_', '+/'));
    $data = json_decode($json, true);

    // Return for debugging or further handling
    return response()->json($data);
});


Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');
