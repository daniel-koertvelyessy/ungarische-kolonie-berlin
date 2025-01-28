<?php

namespace App\Enums;

enum MemberType: string
{
    case ST = "standard";
    case MD = "board";
    case AD = "advisor";
    case AP = "applicant";

    public static function toArray(): array
    {
        return array_column(MemberType::cases(), 'value');
    }


    public static function value(string $value): string
    {
        return match ($value) {
            'standard' => __('member.type.standard'),
            'board' => __('member.type.board'),
            'advisor' => __('member.type.advisor'),
            'applicant' => __('member.type.applicant'),
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'standard' => 'default',
            'board' => 'emerald',
            'advisor' => 'orange',
            'applicant' => 'yellow',
        };
    }
}
