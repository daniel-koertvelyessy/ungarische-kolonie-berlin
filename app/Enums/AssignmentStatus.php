<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;

enum AssignmentStatus: string
{
    case draft = 'draft';
    case pending = 'pending';
    case confirmed = 'confirmed';
    case rejected = 'rejected';
    case completed = 'completed';
    case postponed = 'postponed';

    public static function toArray(): array
    {
        return array_column(AssignmentStatus::cases(), 'value');
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'draft' => __('assignment.status.draft'),
            'pending' => __('assignment.status.pending'),
            'confirmed' => __('assignment.status.confirmed'),
            'rejected' => __('assignment.status.rejected'),
            'completed' => __('assignment.status.retracted'),
            'postponed' => __('assignment.status.postponed'),
            default => throw new InvalidArgumentException("Unknown AssignmentStatus: $value"),
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'draft' => 'zinc',
            'pending' => 'pink',
            'confirmed' => 'lime',
            'rejected' => 'red',
            'completed' => 'emerald',
            'postponed' => 'orange',
            default => throw new InvalidArgumentException("Unknown AssignmentStatus: $value"),
        };
    }
}
