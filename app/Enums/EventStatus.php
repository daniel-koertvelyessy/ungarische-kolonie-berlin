<?php

namespace App\Enums;

use InvalidArgumentException;

enum EventStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';
    case RETRACTED = 'retracted';

    public static function toArray(): array
    {
        return array_column(EventStatus::cases(), 'value');
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'draft' => __('event.type.draft'),
            'pending' => __('event.type.pending'),
            'published' => __('event.type.published'),
            'rejected' => __('event.type.rejected'),
            'retracted' => __('event.type.retracted'),
            default => throw new InvalidArgumentException("Unknown EventStatus: $value"),

        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'draft' => 'gray',
            'pending' => 'teal',
            'published' => 'lime',
            'rejected' => 'yellow',
            'retracted' => 'orange',
            default => throw new InvalidArgumentException("Unknown EventStatus: $value"),

        };
    }
}
