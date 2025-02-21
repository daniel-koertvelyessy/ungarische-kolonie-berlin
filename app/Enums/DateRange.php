<?php

namespace App\Enums;

use Carbon\Carbon;

enum DateRange: string
{
    case All = 'Alle';
    case Today = 'Heute';
    case Week = 'Woche';
    case Last_7 = 'last7';
    case Last_30 = 'last30';
    case Year = 'DiesesJahr';

    public function label(): string
    {
        return match ($this) {
            self::All => 'Alle',
            self::Today => 'Heute',
            self::Week => 'Diese Woche',
            self::Last_7 => 'Letzten 7 Tage',
            self::Last_30 => 'Letzten 30 Tage',
            self::Year => 'Dieses Jahr',
        };
    }

    public function dates(): array
    {
        return match ($this) {
            self::Today => [Carbon::today(), Carbon::now()],
            self::Week => [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()],
            self::Last_7 => [Carbon::today()->subDays(6), Carbon::now()],
            self::Last_30 => [Carbon::today()->subDays(29), Carbon::now()],
            self::Year => [Carbon::now()->startOfYear(), Carbon::now()],
            self::All => [Carbon::now()->startOfCentury(), Carbon::now()],
        };
    }
}
