<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
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

Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');
