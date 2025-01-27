<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'New';
    case BOOKED = 'Booked';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';

    public static function options(): array
    {
        return [
            self::NEW,
            self::BOOKED,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }
}
