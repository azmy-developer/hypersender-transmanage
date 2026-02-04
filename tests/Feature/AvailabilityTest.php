<?php

use App\Models\Trip;
use App\Services\TripAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(RefreshDatabase::class);

it('detects unavailable vehicle during overlapping trip', function () {
    $trip = Trip::factory()->create();

    $service = app(TripAvailabilityService::class);

    expect(
        $service->vehicleAvailable(
            $trip->vehicle_id,
            $trip->starts_at,
            $trip->ends_at
        )
    )->toBeFalse();
});

it('detects available vehicle outside trip time', function () {
    $trip = Trip::factory()->create();

    $service = app(TripAvailabilityService::class);

    expect(
        $service->vehicleAvailable(
            $trip->vehicle_id,
            now()->addDays(1),
            now()->addDays(1)->addHour()
        )
    )->toBeTrue();
});

