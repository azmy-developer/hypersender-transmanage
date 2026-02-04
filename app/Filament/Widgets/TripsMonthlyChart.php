<?php

namespace App\Filament\Widgets;

use App\Models\Trip;
use Filament\Widgets\LineChartWidget;
use Carbon\Carbon;

class TripsMonthlyChart extends LineChartWidget
{
    protected static ?string $heading = 'الرحلات الشهرية';

    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $data = [];

        // نعد الأيام في الشهر الحالي
        $days = collect(range(1, now()->daysInMonth));

        foreach ($days as $day) {
            $date = now()->startOfMonth()->addDays($day - 1);
            $data[$date->format('d')] = Trip::whereDate('starts_at', $date)->count();
        }

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'عدد الرحلات',
                    'data' => array_values($data),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }


}

