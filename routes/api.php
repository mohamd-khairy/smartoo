<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/scribe', function (Request $request) {

    info('here');
    info($request->all());

    return response()->json(['message' => 'Hello World']);
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => 'auth.apikey'], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('/register', [\App\Http\Controllers\API\V1\AuthController::class, 'register'])->name('register');

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/me', [\App\Http\Controllers\API\V1\AuthController::class, 'me'])->name('me');
            Route::put('/profile', [\App\Http\Controllers\API\V1\AuthController::class, 'updateProfile'])->name('update-profile');
            // Route::post('/refresh-token', [\App\Http\Controllers\API\V1\AuthController::class, 'refreshToken'])->name('refresh-token');
            // Route::post('/logout', [\App\Http\Controllers\API\V1\AuthController::class, 'logout'])->name('logout');
        });
    });

    Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum', 'as' => 'users.'], function () {
        //     Route::get('/', [\App\Http\Controllers\API\V1\UserController::class, 'index'])->name('index');
        //     Route::get('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'show'])->name('show');
        //     Route::post('/', [\App\Http\Controllers\API\V1\UserController::class, 'store'])->name('store');
        //     Route::put('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\API\V1\UserController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'translations', 'middleware' => 'auth:sanctum', 'as' => 'translations.'], function () {
        // Route::get('/', [\App\Http\Controllers\API\V1\TranslationController::class, 'index'])->name('index');
        // Route::get('/{id}', [\App\Http\Controllers\API\V1\TranslationController::class, 'show'])->name('show');
        Route::post('/', [\App\Http\Controllers\API\V1\TranslationController::class, 'store'])->name('store');
        // Route::put('/{id}', [\App\Http\Controllers\API\V1\TranslationController::class, 'update'])->name('update');
        // Route::delete('/{id}', [\App\Http\Controllers\API\V1\TranslationController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'subscriptions', 'middleware' => 'auth:sanctum', 'as' => 'subscriptions.'], function () {
        //     Route::get('/', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'show'])->name('show');
        Route::post('/', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'store'])->name('store');
        //     Route::put('/{id}', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\API\V1\SubscriptionController::class, 'destroy'])->name('destroy');
    });

    // Route::group(['prefix' => 'remote-settings', 'middleware' => 'auth:sanctum', 'as' => 'remote-settings.'], function () {
    // Route::get('/', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'index'])->name('index');
    // Route::get('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'show'])->name('show');
    // Route::put('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'update'])->name('update');
    // Route::post('/', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'store'])->name('store');
    // Route::delete('/{country_code}', [\App\Http\Controllers\API\V1\RemoteSettingController::class, 'destroy'])->name('destroy');
    // });


    // Route::group(['prefix' => 'plans', 'as' => 'plans.'], function () {
    //     Route::get('/', [\App\Http\Controllers\API\V1\PlanController::class, 'index'])->name('index');
    //     Route::get('/{id}', [\App\Http\Controllers\API\V1\PlanController::class, 'show'])->name('show');
    //     Route::post('/', [\App\Http\Controllers\API\V1\PlanController::class, 'store'])->name('store');
    //     Route::put('/{id}', [\App\Http\Controllers\API\V1\PlanController::class, 'update'])->name('update');
    //     Route::delete('/{id}', [\App\Http\Controllers\API\V1\PlanController::class, 'destroy'])->name('destroy');
    // });
});
