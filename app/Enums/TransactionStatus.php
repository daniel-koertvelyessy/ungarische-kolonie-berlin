<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case submitted = 'eingereicht';
    case booked = 'gebucht';
    //    case canceled = 'storniert';

    public static function toArray(): array
    {
        return array_column(TransactionStatus::cases(), 'value');
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'eingereicht' => 'gray',
            'gebucht' => 'lime',
            //            'storniert' => 'red',
        };
    }
}
