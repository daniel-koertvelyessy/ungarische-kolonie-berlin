<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;

enum TransactionType: string
{
    case Deposit = 'Einzahlung';
    case Withdrawal = 'Auszahlung';
    case Reversal = 'Storno';

    public static function toArray(): array
    {
        return array_column(TransactionType::cases(), 'value');
    }

    public static function calc(string $value): int
    {
        return match ($value) {
            'Einzahlung' => 1,
            'Auszahlung', 'Storno' => -1,
            default => throw new InvalidArgumentException("Unknown TransactionType: $value"),
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'Einzahlung' => 'positive',
            'Auszahlung' => 'negative',
            'Storno' => 'storno',
            default => throw new InvalidArgumentException("Unknown TransactionType: $value"),

        };
    }

    public static function badgeColor(string $value): string
    {
        return match ($value) {
            'Einzahlung' => 'lime',
            'Auszahlung' => 'orange',
            'Storno' => 'purple',
            default => throw new InvalidArgumentException("Unknown TransactionType: $value"),

        };
    }
}
