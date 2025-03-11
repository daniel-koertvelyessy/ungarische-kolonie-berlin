<?php

namespace App\Enums;

enum PostType: string
{
    case review = 'review';
    case other = 'other';
    case announcement = 'announcement';
    case report = 'report';

    public static function toArray(): array
    {
        return array_column(PostType::cases(), 'value');
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'review' => __('post.type.review'),
            'other' => __('post.type.other'),
            'announcement' => __('post.type.announcement'),
            'report' => __('post.type.report'),
            default => throw new \InvalidArgumentException("Unknown PostType: $value"),

        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'review' => 'lime',
            'other' => 'pink',
            'announcement' => 'orange',
            'report' => 'blue',
            default => throw new \InvalidArgumentException("Unknown PostType: $value"),

        };
    }
}
