<?php

use App\Models\RemoteSetting;
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

Route::get('noti/{testNotificationToken}', function ($testNotificationToken) {

    $jwt = (new AppleJwtService())->generateJwt();

    $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test/{$testNotificationToken}";

    $response = Http::withHeaders([
        'Authorization' => "Bearer {$jwt}",
        'Accept' => 'application/json',
    ])->get($url);

    if ($response->successful()) {
        // Notification status/result
        return $response->json();
    } else {
        // Error handling
        dd($response->status(), $response->json());
    }

});



Route::get('webhook', function () {

    $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test";
    $jwt = (new AppleJwtService())->generateJwt();

    $headers = [
        'Authorization' => "Bearer {$jwt}",
        'Accept' => 'application/json',
    ];

    $response = Http::withHeaders($headers)->post($url);

    // Inspect result
    if ($response->successful()) {
        return $response->json();
    } else {
        // Apple will return error codes/details here if failed
        dd($response->status(), $response->json());
    }

});

Route::get('/scribe/{transactionId}', function ($transactionId) {
    $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/subscriptions";
    $jwt = (new AppleJwtService())->generateJwt();

    $headers = [
        'Authorization' => "Bearer {$jwt}",
        'Accept' => 'application/json',
    ];

    $response = Http::withHeaders($headers)->get($url);

    if (!$response->ok()) {
        abort($response->status(), 'Apple API Error: ' . json_encode($response->json()));
    }

    $body = $response->json();

    dd($body);
    // if (empty($body['signedTransactionInfo'])) {
    //     abort(500, 'No signedTransactionInfo found in response.');
    // }

    // $jws = $body['signedTransactionInfo'];
    // $parts = explode('.', $jws);

    // if (count($parts) !== 3) {
    //     abort(500, 'Malformed JWS!');
    // }

    // // Decode payload (the second part)
    // $payload = $parts[1];
    // $paddedPayload = str_pad($payload, (4 - strlen($payload) % 4) % 4 + strlen($payload), '=', STR_PAD_RIGHT);
    // $json = base64_decode(strtr($paddedPayload, '-_', '+/'));
    // $data = json_decode($json, true);

    // $expiresDateMs = $data['expiresDate'] ?? null; // milliseconds
    // $isActive = false;

    // if ($expiresDateMs) {
    //     $nowMs = (int) (microtime(true) * 1000);
    //     $isActive = ($expiresDateMs > $nowMs);
    // }

    // // Properly add new keys to the response
    // $data = array_merge($data, [
    //     'expiresDate' => $expiresDateMs,
    //     'expiresAt' => $expiresDateMs ? date('Y-m-d H:i:s', $expiresDateMs / 1000) : null,
    //     'isActive' => $isActive,
    // ]);

    // return response()->json($data);
});


Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');
