<?php

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/test', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'store'])->name('store');

Route::get('/', function () {
    try {
        $jwt= "eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiIsImtpZCI6IjZIQzZDUzRUN0cifQ.eyJpc3MiOiIyTFhUVjJaUkpIIiwiaWF0IjoxNzUxOTc1NjQzLCJleHAiOjE3NTE5NzYyNDMsImF1ZCI6ImFwcHN0b3JlY29ubmVjdC12MSIsInN1YiI6ImNvbS50ZWNrLnNtYXJ0b28ifQ.SqEqsPww96PhIW-R22kDt2kUu38I7j2o-rQzr1AsXzwc7I4BrNTakfPvsUpX3QUGA2_Re03lHOtl_MXabZTOtw";
        // The public key from Apple to verify the JWT signature
        $publicKey = file_get_contents(storage_path(env('APPLE_PRIVATE_KEY_PATH')));

        dd($publicKey);
        dd($jwt);
        // Decode and validate the JWT
        $decoded = JWT::decode($jwt, $publicKey, ['ES256']);  // ES256 is the algorithm used by Apple

        // Check the decoded token's claims
        $currentTime = time();
        
        if ($decoded->exp < $currentTime) {
            throw new Exception('JWT has expired');
        }

        // Return decoded token if valid
        return $decoded;
    } catch (Exception $e) {
        // If there is an error (signature is invalid, expired, etc.)
        echo 'JWT validation failed: ' . $e->getMessage();
        return null;
    }
    
    return view('welcome');
});
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

Route::get('/scribe', function () {
    Artisan::call('scribe:generate');
});

Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');
