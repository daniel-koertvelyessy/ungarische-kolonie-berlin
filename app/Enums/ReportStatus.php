<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;

enum ReportStatus: string
{
    case draft = 'entwurf';
    case submitted = 'eingereicht';
    case audited = 'geprueft';

    public static function toArray(): array
    {
        return array_column(ReportStatus::cases(), 'value');
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'eingereicht' => 'gray',
            'entwurf' => 'pink',
            'geprueft' => 'lime',
            default => throw new InvalidArgumentException("Unknown ReportStatus: $value"),

        };
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'eingereicht' => __('reports.status.eingereicht'),
            'entwurf' => __('reports.status.entwurf'),
            'geprueft' => __('reports.status.geprueft'),
            default => throw new InvalidArgumentException("Unknown ReportStatus: $value"),

        };
    }
}
