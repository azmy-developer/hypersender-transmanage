<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return Cache::remember('dashboard.kpis', 60, function () {
            return [
                Stat::make('Active Trips', Trip::active()->count())->icon('heroicon-o-bolt')
                    ->color('danger'),

                Stat::make('Available Drivers',
                    Driver::whereDoesntHave('trips', fn ($q) =>
                    $q->active()
                    )->count()
                )->icon('heroicon-o-user')
                    ->color('success'),
                Stat::make('Available Vehicles', Vehicle::query()->count())
                    ->icon('heroicon-o-truck')
                    ->color('success'),

                Stat::make('Trips This Month',
                    Trip::whereBetween('ends_at', [
                        now()->startOfMonth(),
                        now()
                    ])->count(),
                )->icon('heroicon-o-bolt')
                    ->color('danger'),
            ];
        });
    }
}

