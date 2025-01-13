<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'New';
    case BOOKED = 'Booked';
    case CANCELLED = 'Caclled';

    public static function options(): array
    {
        return [
            self::NEW,
            self::BOOKED,
            self::CANCELLED,
        ];
    }
}
