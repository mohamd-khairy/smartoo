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

Route::get('/scribe/{originalTransactionId}', function ($originalTransactionId) {
    // Artisan::call('scribe:generate');

    // $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/history/{$originalTransactionId}";
    $url = "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/transactions/{$originalTransactionId}";
    $jwt = (new AppleJwtService())->generateJwt();

    $headers = [
        'Authorization' => "Bearer {$jwt}",
    ];

    $response = Http::withHeaders($headers)->get($url);



    return $response;
});

Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');
