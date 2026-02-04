<div class="space-y-4">
    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold">Active Trips</h3>
            <p class="text-xl">{{ $activeTrips }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold">Available Drivers</h3>
            <p class="text-xl">{{ $availableDrivers }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold">Available Vehicles</h3>
            <p class="text-xl">{{ $availableVehicles }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold">Completed This Month</h3>
            <p class="text-xl">{{ $completedThisMonth }}</p>
        </div>
    </div>

    {{-- Today's Trips --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h3 class="font-bold mb-2">Today's Trips</h3>
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Company</th>
                <th class="border px-2 py-1">Driver</th>
                <th class="border px-2 py-1">Vehicle</th>
                <th class="border px-2 py-1">Start</th>
                <th class="border px-2 py-1">End</th>
            </tr>
            </thead>
            <tbody>
            @foreach($todayTrips as $trip)
                <tr>
                    <td class="border px-2 py-1">{{ $trip->company->name }}</td>
                    <td class="border px-2 py-1">{{ $trip->driver->name }}</td>
                    <td class="border px-2 py-1">{{ $trip->vehicle->name }}</td>
                    <td class="border px-2 py-1">{{ $trip->starts_at }}</td>
                    <td class="border px-2 py-1">{{ $trip->ends_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Drivers & Vehicles --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold mb-2">Drivers List</h3>
            <ul>
                @foreach($driversList as $driver)
                    <li>{{ $driver->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold mb-2">Vehicles List</h3>
            <ul>
                @foreach($vehiclesList as $vehicle)
                    <li>{{ $vehicle->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
