<?php

namespace App\Enums;

enum BookingAccountType:string
{
 case Expenses = 'Aufwand';
 case Income = 'Ertrag';
 case Assets = 'Aktiva';
 case Borrowed_capital = 'Fremdkapital';
 case Liabilities = 'Verbindlichkeit';
 case Receivables = 'Forderung';
 case Bank = 'Bank';
 case Cash = 'Bargeld';
 case Credit = ' Haben';

    public static function toArray(): array
    {
        return array_column(BookingAccountType::cases(), 'value');
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

}
