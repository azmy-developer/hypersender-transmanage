<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Navbar badge for active trips
//            Filament::registerNavigationGroups([
//                'Dashboard',
//                'Trips',
//            ]);

//            Filament::registerUserMenuItems([
//                UserMenuItem::make('Active Trips')
//                    ->url('#') // ممكن تروح للصفحة اللي فيها active trips
//                    ->badge(fn() => \App\Models\Trip::active()->count())
//            ]);

//            Filament::registerPages([
//                \App\Filament\Pages\AvailabilityPage::class,
//            ]);
//
//            Filament::registerResources([
//                \App\Filament\Resources\TripResource::class,
//            ]);
        });
    }
}
