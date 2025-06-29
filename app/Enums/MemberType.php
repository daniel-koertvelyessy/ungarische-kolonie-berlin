<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;

enum MemberType: string
{
    case AP = 'applicant';
    case ST = 'standard';
    case AD = 'advisor';
    case MD = 'board';

    public static function toArray(): array
    {
        return array_column(MemberType::cases(), 'value');
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'standard' => __('members.type.standard'),
            'board' => __('members.type.board'),
            'advisor' => __('members.type.advisor'),
            'applicant' => __('members.type.applicant'),
            default => throw new InvalidArgumentException("Unknown MemberType: $value"),

        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'standard' => 'lime',
            'board' => 'emerald',
            'advisor' => 'orange',
            'applicant' => 'yellow',
            default => throw new InvalidArgumentException("Unknown MemberType: $value"),

        };
    }
}
