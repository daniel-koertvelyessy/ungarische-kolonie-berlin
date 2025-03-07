<?php

namespace App\Enums;

enum Locale: string
{
    //    case EN = 'en';
    case DE = 'de';
    case HU = 'hu';

    public static function toArray(): array
    {
        return array_column(Locale::cases(), 'value');
    }

    public static function value(string $value): string
    {

        return match ($value) {
            'de' => __('app.locale.de'),
            'hu' => __('app.locale.hu'),
            default => throw new \InvalidArgumentException("Unknown Locale: $value"),

            //          'diverse' => __('app.diverse'),
        };

    }
}
