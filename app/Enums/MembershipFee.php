<?php

namespace App\Enums;

enum MembershipFee: int
{
    /**
     *  Fees in cent
     */
    case FULL = 500;
    case DISCOUNTED = 300;
    case FREE = 0;

    public static function getFee(int $age): int
    {
        return match (true) {
            $age >= 80 => self::FREE->value,
            $age >= 65 => self::DISCOUNTED->value,
            default => self::FULL->value,
        };
    }
}
