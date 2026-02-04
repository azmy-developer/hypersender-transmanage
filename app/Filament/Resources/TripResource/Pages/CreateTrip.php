<?php

namespace App\Filament\Resources\TripResource\Pages;

use App\Filament\Resources\TripResource;
use App\Services\TripAvailabilityService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;
class CreateTrip extends CreateRecord
{
    protected static string $resource = TripResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            app(TripAvailabilityService::class)->createTrip($data);
        } catch (ValidationException $e) {

            // أول رسالة Validation (Driver أو Vehicle)
            $message = collect($e->errors())->flatten()->first();

            Notification::make()
                ->title('تعذّر إنشاء الرحلة')
                ->body($message)
                ->danger()
                ->send();

            $this->halt();
        }

        return $data;
    }
}
