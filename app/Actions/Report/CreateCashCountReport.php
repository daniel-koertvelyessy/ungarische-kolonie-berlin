<?php

namespace App\Actions\Report;

use App\Livewire\Forms\CashCountForm;
use App\Models\Accounting\CashCount;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class CreateCashCountReport extends Action
{
    public static function handle(CashCountForm $form): CashCount
    {
        return DB::transaction(function () use ($form) {
            return CashCount::query()->create([
                'counted_at' => $form->counted_at,
                'account_id' => $form->account_id,
                'label' => $form->label,
                'notes' => $form->notes,
                'user_id' => $form->user_id,
                'euro_two_hundred' => $form->euro_two_hundred,
                'euro_one_hundred' => $form->euro_one_hundred,
                'euro_fifty' => $form->euro_fifty,
                'euro_twenty' => $form->euro_twenty,
                'euro_ten' => $form->euro_ten,
                'euro_five' => $form->euro_five,
                'euro_two' => $form->euro_two,
                'euro_one' => $form->euro_one,
                'cent_fifty' => $form->cent_fifty,
                'cent_twenty' => $form->cent_twenty,
                'cent_ten' => $form->cent_ten,
                'cent_five' => $form->cent_five,
                'cent_two' => $form->cent_two,
                'cent_one' => $form->cent_one,
            ]);
        });

    }
}
