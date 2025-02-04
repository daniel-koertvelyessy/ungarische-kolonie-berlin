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

}
