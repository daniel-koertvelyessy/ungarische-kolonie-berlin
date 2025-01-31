<?php

namespace App\Enums;

enum MemberType: string
{
    case AP = "applicant";
    case ST = "standard";
    case AD = "advisor";
    case MD = "board";

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
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'standard' => 'lime',
            'board' => 'emerald',
            'advisor' => 'orange',
            'applicant' => 'yellow',
        };
    }
}
