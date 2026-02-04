<?php

use App\Models\Trip;
use App\Services\TripAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

//uses(RefreshDatabase::class);

it('creates a trip when driver and vehicle are available', function () {
    $trip = Trip::factory()->make()->toArray();

    $service = app(TripAvailabilityService::class);

    $created = $service->createTrip($trip);

    expect($created)->toBeInstanceOf(Trip::class);
    expect(Trip::count())->toBe(1);
});

it('throws validation exception if driver is busy', function () {
    $existing = Trip::factory()->create();

    $service = app(TripAvailabilityService::class);

    $data = Trip::factory()->make([
        'driver_id' => $existing->driver_id,
        'starts_at' => $existing->starts_at,
        'ends_at' => $existing->ends_at,
    ])->toArray();

    expect(fn () => $service->createTrip($data))
        ->toThrow(ValidationException::class);
});

