<?php

namespace App\Enums;

enum MemberFamilyStatus: string
{
    case SI = "single";
    case MA = "married";
    case DI = "divorced";
    case NN = "n_a";

    public static function toArray(): array
    {
        return array_column(MemberFamilyStatus::cases(), 'value');
    }


    public static function value(string $value): string
    {
        return match ($value) {
            'single' => __('members.familystatus.single'),
            'married' => __('members.familystatus.married'),
            'divorced' => __('members.familystatus.divorced'),
            'n_a' => __('members.familystatus.n_a'),
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            'single' => 'lime',
            'married' => 'emerald',
            'divorced' => 'yellow',
            'n_a' => 'zinc',
        };
    }
}
