<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->databaseTransactions()
            // ->brandLogo('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSw_JmAXuH2Myq0ah2g_5ioG6Ku7aR02-mcvimzwFXuD25p2bjx7zhaL34oJ7H9khuFx50&usqp=CAU')
            ->favicon('images/logo.png')
            ->brandName(env('APP_NAME'))
            ->collapsibleNavigationGroups(true)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15rem')
            ->globalSearch(true)
            ->spa()
            ->userMenuItems([
                MenuItem::make()
                    ->label(__('resources.arabic'))
                    ->icon('heroicon-o-language')
                    ->url('javascript:toggleDirection()') // Call the JavaScript function
                    ->openUrlInNewTab(false)
                    ->visible(fn(): bool => config('app.locale') === 'en')
                    ->hidden(fn(): bool => !config('app.locale') === 'en'),

                MenuItem::make()
                    ->label(__('resources.english'))
                    ->icon('heroicon-o-language')
                    ->openUrlInNewTab(false)
                    ->url('javascript:toggleDirection()') // Call the JavaScript function
                    ->visible(fn(): bool => config('app.locale') === 'ar')
                    ->hidden(fn(): bool => ! config('app.locale') === 'ar'),
                // ...
            ]);
    }
}
