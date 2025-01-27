<?php

namespace App\Enums;

enum BookingStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case ONGOING = 'ongoing';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public static function options(): array
    {
        return [
            self::NEW,
            self::PENDING,
            self::ACCEPTED,
            self::ONGOING,
            self::CANCELLED,
            self::COMPLETED,
        ];
    }
}
