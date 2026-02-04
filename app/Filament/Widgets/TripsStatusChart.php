<?php

namespace App\Filament\Widgets;

use App\Enum\TripStatus;
use App\Models\Trip;
use Filament\Widgets\ChartWidget;

class TripsStatusChart extends ChartWidget
{
    protected static ?string $heading = 'توزيع الرحلات حسب الحالة';

    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '260px';
    protected static bool $isLazy = true;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'الحالة',
                    'data' => [
                        Trip::where('status', TripStatus::SCHEDULED->value)->count(),
                        Trip::where('status', TripStatus::ACTIVE->value)->count(),
                        Trip::where('status', TripStatus::CANCELLED->value)->count(),
                    ],
                    'backgroundColor' => ['#facc15', '#22c55e', '#3b82f6'], // ألوان مميزة
                    'hoverOffset' => 4,
                    'borderWidth' => 0,
                    'cutout' => '70%',
                    'radius' => '90%',
                    'spacing' => 2,
                    'offset' => 0,
                    'rotation' => 0,
                    'circumference' => 360,
                    'weight' => 1,
                    'fill' => true,


                ],
            ],
            'height' => 50,
            'labels' => ['مجدولة', 'نشطة', 'مكتملة'],
        ];
    }



    protected function getType(): string
    {
        return 'pie';
    }
}
