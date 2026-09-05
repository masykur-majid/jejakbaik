<?php

namespace App\Providers\Filament;

use App\Filament\Resources\ConductRules\ConductRuleResource;
use App\Filament\Resources\PointLogs\PointLogResource;
use App\Filament\Resources\StudentPoints\StudentPointResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ParapointPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('parapoint')
            ->path('parapoint')
            ->viteTheme('resources/css/filament/parapoint/theme.css')
            ->maxContentWidth('full')
            ->profile()
            ->topNavigation()
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                ConductRuleResource::class,
                PointLogResource::class,
                StudentPointResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Parapoint/Pages'), for: 'App\Filament\Parapoint\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Parapoint/Widgets'), for: 'App\Filament\Parapoint\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
