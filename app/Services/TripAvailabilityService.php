<?php

namespace App\Services;

use App\Models\Trip;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TripAvailabilityService
{
    public function createTrip(array $tripData): Trip
    {
        return DB::transaction(function() use ($tripData) {

            // Lock driver & vehicle rows
            $driver = \App\Models\Driver::where('id',$tripData['driver_id'])->lockForUpdate()->first();
            $vehicle = \App\Models\Vehicle::where('id',$tripData['vehicle_id'])->lockForUpdate()->first();

            $starts = Carbon::parse($tripData['starts_at']);
            $ends = Carbon::parse($tripData['ends_at']);

            // Check availability
            if (! $this->driverAvailable($driver->id, $starts, $ends)) {
                throw ValidationException::withMessages([
                    'driver_id' => 'السائق غير متاح في هذا التوقيت',
                ]);
            }

            if (! $this->vehicleAvailable($vehicle->id, $starts, $ends)) {
                throw ValidationException::withMessages([
                    'vehicle_id' => 'المركبة غير متاحة في هذا التوقيت',
                ]);
            }

            // Create trip
            return Trip::create($tripData);
        });
    }

    public function driverAvailable(int $driverId, Carbon $starts, Carbon $ends, ?int $ignoreTripId = null): bool {
        return !Trip::where('driver_id',$driverId)
            ->when($ignoreTripId, fn($q)=>$q->where('id','!=',$ignoreTripId))
            ->overlapping($starts,$ends)
            ->exists();
    }

    public function vehicleAvailable(int $vehicleId, Carbon $starts, Carbon $ends, ?int $ignoreTripId = null): bool {
        return !Trip::where('vehicle_id',$vehicleId)
            ->when($ignoreTripId, fn($q)=>$q->where('id','!=',$ignoreTripId))
            ->overlapping($starts,$ends)
            ->exists();
    }
}
