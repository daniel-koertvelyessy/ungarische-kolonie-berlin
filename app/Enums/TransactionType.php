<?php

namespace App\Enums;

enum TransactionType:string
{
 case Deposit = 'Einzahlung';
 case Withdrawal = 'Auszahlung';
 case Reversal = 'Storno';

    public static function toArray(): array
    {
        return array_column(TransactionType::cases(), 'value');
    }


    public static function value(string $value): string
    {
        return match ($value) {
            'Deposit' => 'lime',
            'Withdrawal' => 'orange',
            'Reversal' => 'red',
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'Deposit' => 'lime',
            'Withdrawal' => 'orange',
            'Reversal' => 'red',
        };
    }
}
