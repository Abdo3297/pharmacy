<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Pharmacy;
use Filament\PanelProvider;
use App\Filament\Pages\Dashboard;
use Filament\View\PanelsRenderHook;
use App\Filament\Widgets\UsersChart;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\RevenuChart;
use App\Filament\Widgets\StatsWidget;
use App\Filament\Widgets\StoreWidget;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->brandLogo(url('assets/images/logo.png'))
            ->brandLogoHeight('3.5rem')
            ->favicon(url('assets/images/logo.png'))
            ->colors([
                'primary' => '#37afb5',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StoreWidget::class,
                StatsWidget::class,
                UsersChart::class,
                OrdersChart::class,
                RevenuChart::class,
            ])
            ->sidebarCollapsibleOnDesktop(true)
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
            ->databaseNotifications()
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Customers')->collapsed(),
                NavigationGroup::make()
                    ->label('Store')->collapsed(),
                NavigationGroup::make()
                    ->label('Offers')->collapsed(),
                NavigationGroup::make()
                    ->label('Orders')->collapsed(),
                NavigationGroup::make()
                    ->label('Settings')->collapsed(),
            ])
            ->plugins(
                [
                    BreezyCore::make()->myProfile(),
                    SpatieLaravelTranslatablePlugin::make()->defaultLocales(['en', 'ar']),
                    FilamentApexChartsPlugin::make()
                ]
            );
    }
}
