<?php

namespace App\Enums;

enum Locale:string
{
//    case EN = 'en';
    case DE = 'de';
    case HU = 'hu';

    public static function toArray(): array
    {
        return array_column(Locale::cases(), 'value');
    }
}
