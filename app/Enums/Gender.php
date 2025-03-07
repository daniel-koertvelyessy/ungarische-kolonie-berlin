<?php

namespace App\Enums;

enum Gender: string
{
    case ma = 'male';
    case fe = 'female';
    //    case di = 'diverse';

    public static function toArray(): array
    {
        return array_column(Gender::cases(), 'value');
    }

    public static function value(string $value): string
    {

        return match ($value) {
            'male' => __('app.male'),
            'female' => __('app.female'),
            //          'diverse' => __('app.diverse'),
            default => throw new \InvalidArgumentException("Unknown Gender: $value"),

        };

    }
}
