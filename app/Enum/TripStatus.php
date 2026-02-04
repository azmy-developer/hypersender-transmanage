<?php

namespace App\Enum;

enum TripStatus: string {
    case SCHEDULED = 'scheduled';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function toArray(): array
    {
        return [
            self::SCHEDULED->value,
            self::ACTIVE->value,
            self::COMPLETED->value,
            self::CANCELLED->value,

        ];
    }

    public function getValue(): int
    {
        return $this->value;
    }

}
