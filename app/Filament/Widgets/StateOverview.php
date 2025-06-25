<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StateOverview extends BaseWidget
{
    // protected ?string $heading = 'Analytics';
    // protected ?string $description = 'An overview of some analytics.';
    protected static ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        return [
            Stat::make(__('resources.users'), \App\Models\User::count())
                ->url('/admin/users')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
            Stat::make(__('resources.remote_settings'), \App\Models\RemoteSetting::count()),
            Stat::make(__('resources.translations'), \App\Models\Translation::count()),
            Stat::make(__('resources.plans'), \App\Models\Plan::count()),
            Stat::make(__('resources.subscriptions'), \App\Models\Subscription::count()),
        ];
    }
}
