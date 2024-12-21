<?php

namespace App\Enums;

enum CardType: string
{
    case Debit = 'debit';
    case Credit = 'credit';

    public function options(): array
    {
        return [
            self::Debit => true,
            self::Credit => false,
        ];
    }
}
