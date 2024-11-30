<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case BOOKED = 'Booked';

    public static function options(): array
    {
        return [
            self::NEW,
            self::PENDING,
            self::BOOKED,
        ];
    }
}
