<?php

namespace App\Enums;

enum Gender
{
    case ma;
    case fe;
    case di;


    public static function toArray(): array
    {
        return array_column(Gender::cases(), 'value');
    }


}
