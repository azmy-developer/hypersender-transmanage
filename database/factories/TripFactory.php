<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Trip::class;

    public function definition()
    {
        // اختار Driver و Vehicle موجودين
        $driver = Driver::inRandomOrder()->first();
        $vehicle = Vehicle::inRandomOrder()->first();

        // خلي الرحلة تبدأ بعد آخر رحلة للـ driver أو vehicle
        $lastTrip = Trip::where('driver_id', $driver->id)
            ->orWhere('vehicle_id', $vehicle->id)
            ->orderByDesc('ends_at')
            ->first();

        $starts = $lastTrip ? Carbon::parse($lastTrip->ends_at)->addMinutes(rand(30, 120)) : Carbon::now()->addMinutes(rand(30, 120));
        $ends = (clone $starts)->addHours(rand(1, 5));

        return [
            'company_id' => $driver->company_id,
            'driver_id' => $driver->id,
            'vehicle_id' => $vehicle->id,
            'starts_at' => $starts,
            'ends_at' => $ends,
            'status' => 'scheduled',
        ];
    }
}
