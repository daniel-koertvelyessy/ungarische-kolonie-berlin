<?php

namespace App\Enums;

enum MemberType:string
{
    case ST="standard";
    case MD="board";
    case AD="advisor";

    public static function toArray(): array
    {
        return array_column(MemberType::cases(), 'value');
    }


    public static function value(string $value): string{

        return match ($value) {
            'male' => __('app.male'),
            'female' => __('app.female'),
//          'diverse' => __('app.diverse'),
        };

    }

    public static function color(string $value): string{
        return match ($value) {
            'standard' => 'default',
            'board' => 'emerald',
          'advisor' => 'orange',
        };

    }
}
