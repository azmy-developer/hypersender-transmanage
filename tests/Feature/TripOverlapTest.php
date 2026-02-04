<?php

use App\Models\Trip;
use App\Services\TripAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(RefreshDatabase::class);

it('prevents overlapping trips for the same driver', function () {
    $trip = Trip::factory()->create([
        'starts_at' => now()->addHour(),
        'ends_at' => now()->addHours(3),
    ]);

    $service = app(TripAvailabilityService::class);

    $available = $service->driverAvailable(
        $trip->driver_id,
        now()->addHours(2),
        now()->addHours(4)
    );

    expect($available)->toBeFalse();
});

it('allows non-overlapping trips for the same driver', function () {
    $trip = Trip::factory()->create([
        'starts_at' => now()->addHour(),
        'ends_at' => now()->addHours(2),
    ]);

    $service = app(TripAvailabilityService::class);

    $available = $service->driverAvailable(
        $trip->driver_id,
        now()->addHours(3),
        now()->addHours(4)
    );

    expect($available)->toBeTrue();
});

