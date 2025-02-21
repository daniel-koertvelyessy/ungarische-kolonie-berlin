<?php

namespace App\Enums;

enum MemberFeeType: string
{
    case FREE = 'free';
    case FULL = 'full';
    case DISC = 'discounted';

    public static function toArray(): array
    {
        return array_column(MemberFeeType::cases(), 'value');
    }

    public static function value(string $value): string
    {
        return match ($value) {
            'free' => __('members.fee-type.free'),
            'full' => __('members.fee-type.standard'),
            'discounted' => __('members.fee-type.discounted'),
        };
    }

    public static function fee(string $value): int
    {

        return match ($value) {
            'standard' => MembershipFee::FULL->value,
            'free' => MembershipFee::FREE->value,
            'full' => MembershipFee::FULL->value,
            'discounted' => MembershipFee::DISCOUNTED->value,
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'free' => 'lime',
            'full' => 'emerald',
            'discounted' => 'orange',
        };
    }
}
