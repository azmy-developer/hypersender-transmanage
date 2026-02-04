<x-filament-panels::page>

    {{-- من و إلى --}}
    <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 items-end">
        <x-filament::input type="datetime-local" wire:model="from" placeholder="From" class="flex-1"/>
        <x-filament::input type="datetime-local" wire:model="to" placeholder="To" class="flex-1"/>
        <x-filament::button wire:click="checkAvailability" color="primary" class="h-12 px-6 text-white font-semibold">Check Availability</x-filament::button>
    </div>

    {{-- الكروت --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Available Drivers --}}
        <div class=" shadow-lg rounded-2xl p-5 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-indigo-600">Available Drivers</h3>
                <span class="text-sm text-gray-500">{{ $availableDrivers->count() }} available</span>
            </div>

            @if($availableDrivers->isEmpty())
                <p class="text-gray-400 italic">No drivers available in this time range.</p>
            @else
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach($availableDrivers as $driver)
                        <div class="flex justify-between items-center p-3 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition cursor-pointer shadow-sm">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-user class="w-6 h-6 text-indigo-500"/>
                                <div>
                                    <div class="font-medium text-indigo-700">{{ $driver->name }}</div>
                                    @if($driver->email)
                                        <div class="text-xs text-gray-500">{{ $driver->email }}</div>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm text-gray-400">{{ $driver->trips->count() ?? 0 }} trips</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Available Vehicles --}}
        <div class=" shadow-lg rounded-2xl p-5 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-indigo-600">Available Vehicles</h3>
                <span class="text-sm text-gray-500">{{ $availableVehicles->count() }} available</span>
            </div>

            @if($availableVehicles->isEmpty())
                <p class="text-gray-400 italic">No vehicles available in this time range.</p>
            @else
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach($availableVehicles as $vehicle)
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-xl hover:bg-green-100 transition cursor-pointer shadow-sm">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-truck class="w-6 h-6 text-green-500"/>
                                <div>
                                    <div class="font-medium text-green-700">{{ $vehicle->name }}</div>
                                    @if($vehicle->plate_number)
                                        <div class="text-xs text-gray-500">{{ $vehicle->plate_number }}</div>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm text-gray-400">{{ $vehicle->trips->count() ?? 0 }} trips</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</x-filament-panels::page>
