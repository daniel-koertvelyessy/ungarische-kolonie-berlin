<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case submitted = 'eingereicht';
    case booked = 'gebucht';
    case reversed = 'storniert';

    public static function toArray(): array
    {
        return array_column(TransactionStatus::cases(), 'value');
    }


    public static function value(string $value): string
    {
        return match ($value) {
            'submitted' => 'gray',
            'booked' => 'lime',
            'reversed' => 'red',
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'submitted' => 'gray',
            'booked' => 'lime',
            'reversed' => 'red',
        };
    }
}
