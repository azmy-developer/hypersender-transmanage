<?php

namespace App\Filament\Pages;

use App\Enum\TripStatus;
use Filament\Pages\Page;
use App\Models\Driver;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityPage extends Page
{
    protected static ?string $title = 'Availability Checker';
    protected static string $view = 'filament.pages.availability-page';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 9;

    // Livewire properties
    public $from;
    public $to;
    public $availableDrivers;
    public $availableVehicles;

    public function mount()
    {
        $this->availableDrivers = collect(); // simple collection
        $this->availableVehicles = collect();
    }

    public function checkAvailability()
    {
        $from = Carbon::parse($this->from);
        $to = Carbon::parse($this->to);

        // Get drivers and vehicles not booked in this period
        $this->availableDrivers = Driver::whereDoesntHave('trips', fn($q) =>
        $q->overlapping($from, $to)
            ->whereIn('status', [TripStatus::SCHEDULED->value, TripStatus::ACTIVE->value])
        )->get();

        $this->availableVehicles = Vehicle::whereDoesntHave('trips', fn($q) =>
        $q->overlapping($from, $to)
            ->whereIn('status', [TripStatus::SCHEDULED->value, TripStatus::ACTIVE->value])
        )->get();
    }
}
