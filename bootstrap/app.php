<?php

use App\Console\Commands\CheckActiveSubscriptions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
        //     return api_response(message: 'Unauthenticated.', statusCode: 401);
        // });
    
        // $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
        //     // First, get the errors array and shift the first field's errors
        //     $errors = $e->errors();
        //     $firstError = array_shift($errors); // This gets the first field's errors
    
        //     // Then get the first error message from that array
        //     $firstErrorMessage = $firstError[0]; // Get the first message of the first field's errors
    
        //     // Return the first validation error message
        //     return api_response(
        //         message: $firstErrorMessage,
        //         statusCode: 422
        //     );
        // });
    })->withCommands([
            CheckActiveSubscriptions::class,
        ])->create();
