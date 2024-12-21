<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'New';
    case PENDING = 'Pending';
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
