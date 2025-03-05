<?php

namespace App\Livewire\Forms;

use App\Actions\Report\CreateCashCountReport;
use App\Models\Accounting\CashCount;
use Livewire\Form;

class CashCountForm extends Form
{
    public CashCount $cashCount;
    public $account_id;
    public $user_id;
    public $counted_at;
    public $label;
    public $notes;
    public $euro_two_hundred;
    public $euro_one_hundred;
    public $euro_fifty;
    public $euro_twenty;
    public $euro_ten;
    public $euro_five;
    public $euro_two;
    public $euro_one;
    public $cent_fifty;
    public $cent_twenty;
    public $cent_ten;
    public $cent_five;
    public $cent_two;
    public $cent_one;





    public function set(int $id):void
    {
        $this->cashCount = CashCount::query()->findOrFail($id);
        $this->counted_at = $this->cashCount->counted_at;
        $this->account_id = $this->cashCount->account_id;
        $this->label = $this->cashCount->label;
        $this->notes = $this->cashCount->notes;
        $this->user_id = $this->cashCount->user_id;
        $this->euro_two_hundred = $this->cashCount->euro_two_hundred;
        $this->euro_one_hundred = $this->cashCount->euro_one_hundred;
        $this->euro_fifty = $this->cashCount->euro_fifty;
        $this->euro_twenty = $this->cashCount->euro_twenty;
        $this->euro_ten = $this->cashCount->euro_ten;
        $this->euro_five = $this->cashCount->euro_five;
        $this->euro_two = $this->cashCount->euro_two;
        $this->euro_one = $this->cashCount->euro_one;
        $this->cent_fifty = $this->cashCount->cent_fifty;
        $this->cent_twenty = $this->cashCount->cent_twenty;
        $this->cent_ten = $this->cashCount->cent_ten;
        $this->cent_five = $this->cashCount->cent_five;
        $this->cent_two = $this->cashCount->cent_two;
        $this->cent_one = $this->cashCount->cent_one;
    }

    public function create():CashCount
    {
        $this->validate();
       return CreateCashCountReport::handle($this);
    }

    public function update()
    {

    }


    protected function rules(): array{
        return [
            'account_id' => 'required',
            'user_id' => 'required',
            'label' => 'required|string',
            'notes' => 'nullable|string',
            'counted_at' => 'required|date',
            'euro_two_hundred' => 'nullable|integer',
            'euro_one_hundred' => 'nullable|integer',
            'euro_fifty' => 'nullable|integer',
            'euro_twenty' => 'nullable|integer',
            'euro_ten' => 'nullable|integer',
            'euro_five' => 'nullable|integer',
            'euro_two' => 'nullable|integer',
            'euro_one' => 'nullable|integer',
            'cent_fifty' => 'nullable|integer',
            'cent_twenty' => 'nullable|integer',
            'cent_ten' => 'nullable|integer',
            'cent_five' => 'nullable|integer',
            'cent_two' => 'nullable|integer',
            'cent_one' => 'nullable|integer',

        ];
    }
}
