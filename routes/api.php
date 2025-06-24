<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    Route::post('change-language', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'changeLanguage'])->name('change-language');

    Route::group(['prefix' => 'remote-settings', 'middleware' => 'auth:sanctum', 'as' => 'remote-settings.'], function () {
        Route::get('/', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'index'])->name('index');
        Route::get('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'show'])->name('show');
        Route::put('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'update'])->name('update');
        Route::post('/', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'store'])->name('store');
        Route::delete('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'translations', 'middleware' => 'auth:sanctum', 'as' => 'translations.'], function () {
        Route::get('/', [\App\Http\Controllers\API\V1\TranslationController::class, 'index'])->name('index');
        Route::get('/{locale}', [\App\Http\Controllers\API\V1\TranslationController::class, 'show'])->name('show');
        Route::post('/', [\App\Http\Controllers\API\V1\TranslationController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\API\V1\TranslationController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\API\V1\TranslationController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'users',  'middleware' => 'auth:sanctum', 'as' => 'users.'], function () {
        Route::get('/', [\App\Http\Controllers\API\V1\UserController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'show'])->name('show');
        Route::post('/', [\App\Http\Controllers\API\V1\UserController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('/register', [\App\Http\Controllers\API\V1\AuthController::class, 'register'])->name('register');
        Route::post('/login', [\App\Http\Controllers\API\V1\AuthController::class, 'login'])->name('login');
        Route::post('/verify-phone', [\App\Http\Controllers\API\V1\AuthController::class, 'verifyPhoneNumber'])->name('verify-phone');

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/logout', [\App\Http\Controllers\API\V1\AuthController::class, 'logout'])->name('logout');
            Route::get('/profile', [\App\Http\Controllers\API\V1\AuthController::class, 'profile'])->name('profile');
            Route::put('/profile', [\App\Http\Controllers\API\V1\AuthController::class, 'updateProfile'])->name('update-profile');
            Route::post('/refresh-token', [\App\Http\Controllers\API\V1\AuthController::class, 'refreshToken'])->name('refresh-token');
        });
    });
});
