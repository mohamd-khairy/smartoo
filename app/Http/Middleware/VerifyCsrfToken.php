<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // For webhooks, no leading slash, use full path (relative to domain root)
        'scribe',
        // Add other URIs as needed, e.g., 'api/*' if necessary
    ];
}
