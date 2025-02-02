<?php

namespace App\Enums;

enum AccountType:string
{
    case cash = 'bar';
    case bank = 'bank';
    case paypal = 'paypal';


    public static function toArray(): array
    {
        return array_column(AccountType::cases(), 'value');
    }

    public static function value(string $value): string{

        return match ($value) {
            AccountType::bank->value => __('app.locale.de'),
            AccountType::cash->value => __('app.locale.hu'),
            AccountType::paypal->value => __('app.locale.hu'),
        };

    }
}
