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
