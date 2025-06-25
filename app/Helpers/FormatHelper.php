<?php

namespace App\Helpers;

class FormatHelper
{
    public static function formatValueHistory($key, $value)
    {
        if (in_array($key, ['amount_gross', 'vat', 'tax']) && is_numeric($value)) {
            return number_format($value, 2, ',', '.').' €';
        }

        return is_string($value) ? trim($value) : json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function tryParseJson($value)
    {
        if (! is_string($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }
}
