<?php

use App\Models\Trip;
use App\Enum\TripStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(RefreshDatabase::class);

it('counts active trips correctly', function () {
    Trip::factory()->count(3)->create([
        'status' => TripStatus::ACTIVE->value,
    ]);

    Trip::factory()->count(2)->create([
        'status' => TripStatus::COMPLETED->value,
    ]);

    expect(
        Trip::where('status', TripStatus::ACTIVE->value)->count()
    )->toBe(3);
});

it('counts completed trips this month', function () {
    Trip::factory()->create([
        'status' => TripStatus::COMPLETED->value,
        'ends_at' => now()->startOfMonth()->addDay(),
    ]);

    Trip::factory()->create([
        'status' => TripStatus::COMPLETED->value,
        'ends_at' => now()->subMonth(),
    ]);

    $count = Trip::where('status', TripStatus::COMPLETED->value)
        ->whereMonth('ends_at', now()->month)
        ->count();

    expect($count)->toBe(1);
});

