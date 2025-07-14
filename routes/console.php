<?php

use App\Console\Commands\CheckActiveSubscriptions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('subscriptions:check', function () {
    $this->comment(CheckActiveSubscriptions::quote());
})->purpose('Display an subscriptions:check');