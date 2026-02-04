<?php
namespace App\Filament\Resources;

use App\Enum\TripStatus;
use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip;
use App\Services\TripAvailabilityService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return cache()->remember('trips_count', 60, fn () => Trip::count());
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('company_id')
                ->relationship('company','name')
                ->required()
                ->reactive(), // مهم لتحديث الحقول المرتبطة

            Select::make('driver_id')
                ->relationship('driver','name')
                ->required()
                ->reactive(),

            Select::make('vehicle_id')
                ->relationship('vehicle','name')
                ->required()
                ->reactive(),

            DateTimePicker::make('starts_at')->required()->reactive(),
            DateTimePicker::make('ends_at')->required()->reactive(),

            Select::make('status')
                ->options(TripStatus::toArray())
                ->label('Status')
                ->default('scheduled'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')->label('Company'),
                Tables\Columns\TextColumn::make('driver.name')->label('Driver'),
                Tables\Columns\TextColumn::make('vehicle.name')->label('Vehicle'),
                Tables\Columns\TextColumn::make('starts_at')->dateTime(),
                Tables\Columns\TextColumn::make('ends_at')->dateTime(),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')->query(fn($q) => $q->where('status','scheduled')),
            ])
            ->defaultSort('starts_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['company', 'driver', 'vehicle']); // لتجنب N+1
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
