Hypersender Transportation Management App
Overview

A transportation management app built with Laravel 11 and Filament v3.
Manages companies, drivers, vehicles, and trips with overlapping prevention and availability checks.

Setup
git clone https://github.com/azmy-developer/hypersender-transmanage.git
cd hypersender-transmanage
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve


Admin panel: /admin

Sample users seeded for testing

Database & Relationships
Table	Important Columns
companies	id, name, active
drivers	id, name, license_number, phone, active
vehicles	id, name, active
trips	id, company_id, driver_id, vehicle_id, starts_at, ends_at, status

One company → many drivers, vehicles, trips

Driver → multiple vehicles & trips

Vehicle → multiple trips

Trip → linked to company, driver, vehicle

Filament Resources

Company, Driver, Vehicle, Trip

TripResource:

Prevent overlapping trips

Status uses Enum: scheduled, active, completed, cancelled

Validation errors displayed in Filament popup (Arabic messages)

Business Logic

TripAvailabilityService:

driverAvailable(driver_id, starts, ends)

vehicleAvailable(vehicle_id, starts, ends)

createTrip($data) uses DB transaction + lockForUpdate

Validation popup messages (Arabic) for unavailable driver/vehicle

Dashboard & Widgets

StatsOverviewWidget:

Active trips

Available drivers & vehicles

Completed trips this month

TripsStatusChart:

Pie chart for trips by status

Customized size and colors

max-w-[300px] h-64 for compact display

Factories & Seeders

Companies, Drivers, Vehicles, Trips generated with factories

Seeder creates realistic sample data for testing

Testing (Pest)

Pest used with RefreshDatabase

Covers:

Trip overlap validation

Driver/Vehicle availability

KPIs

Example test:

it('prevents overlapping trips for the same driver', function () {
$trip = Trip::factory()->create([
'starts_at' => now()->addHour(),
'ends_at' => now()->addHours(3),
]);
$service = app(TripAvailabilityService::class);
expect($service->driverAvailable($trip->driver_id, now()->addHours(2), now()->addHours(4)))->toBeFalse();
});


Run tests:

./vendor/bin/pest


Coverage ≥ 80% recommended

Technical Notes

Enums for trip status

Transactions + row locking to prevent conflicts

Avoid N+1 queries with with() on relationships

Cached counts for KPIs in widgets

Assumptions

Trips defined by starts_at → ends_at

Any overlap is prohibited

KPIs displayed as numbers & charts

Arabic messages for Filament forms

Version Control

Frequent commits with clear messages for each step
