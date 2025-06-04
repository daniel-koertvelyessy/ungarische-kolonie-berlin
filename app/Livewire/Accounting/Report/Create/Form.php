<?php

namespace App\Livewire\Accounting\Report\Create;

use App\Enums\ReportStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Livewire\Forms\Accounting\AccountReportForm;
use App\Livewire\Traits\HasPrivileges;
use App\Models\Accounting\Account;
use App\Models\Accounting\AccountReport;
use App\Models\Accounting\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    use HasPrivileges;

    public $setRange;

    public $transactions;

    public $msg;

    public Account $account;

    public AccountReportForm $form;

    public function updatedSetRange(): void
    {
        $this->form->period_start = Carbon::create(date('Y'), (int) $this->setRange)
            ->format('Y-m-d');
        $this->form->period_end = Carbon::create(date('Y'), (int) $this->setRange)
            ->endOfMonth()
            ->format('Y-m-d');
    }

    public function mount($accountId): void
    {
        $this->account = Account::query()->findOrFail($accountId);
        $this->setRange = Carbon::today('Europe/Berlin')->month;
        $this->formInit();
    }

    public function storeReportData(): void
    {
        $this->checkPrivilege(AccountReport::class);
        $this->form->created_by = Auth::user()->id;
        $this->form->status = ReportStatus::draft->value;

        $this->form->create();
    }

    public function getTransactions(): void
    {
        $this->transactions = Transaction::query()
            ->select('id', 'amount_gross', 'type', 'label', 'account_id')
            ->where('account_id', '=', $this->account->id)
            ->where('status', TransactionStatus::booked->value)
            ->whereBetween('date', [$this->form->period_start, $this->form->period_end])
            ->get();

        $this->setLastReportItems();

        if ($this->transactions->count() > 0) {
            $this->formInit();
            $this->form->end_amount = $this->form->starting_amount;

            foreach ($this->transactions as $transaction) {
                $amount = (int) ($transaction->amount_gross ?? 0);
                $multiplier = TransactionType::calc($transaction->type);

                //                if (! is_numeric($amount) || ! is_numeric($multiplier)) {
                //                    throw new \Exception("Invalid values: amount_gross={$amount}, multiplier={$multiplier}");
                //                }

                $this->form->end_amount += $amount * $multiplier;

                if ($transaction->type === TransactionType::Deposit->value) {
                    $this->form->total_income += $amount;
                } else {
                    $this->form->total_expenditure += $amount;
                }
            }

            $this->msg = $this->transactions->count().' Buchungen gefunden';

        }
        $this->form->starting_amount = $this->numfor($this->form->starting_amount);
        $this->form->end_amount = $this->numfor($this->form->end_amount);
        $this->form->total_income = $this->numfor($this->form->total_income);
        $this->form->total_expenditure = $this->numfor($this->form->total_expenditure);
    }

    protected function setLastReportItems(): void
    {
        $report = AccountReport::latest()
            ->first();

        if ($report) {
            $this->form->starting_amount = $report->end_amount;
        } else {
            $this->form->starting_amount = $this->account->starting_amount;
            $this->form->end_amount = $this->account->starting_amount;
        }
    }

    protected function numfor($value): string
    {

        if (is_null($value)) {
            return '0';
        }

        return number_format((int) $value / 100, 2, ',');
    }

    protected function formInit(): void
    {
        $this->form->account_id = $this->account->id;
        $this->form->period_start = Carbon::create(date('Y'), (int) date('m'))
            ->format('Y-m-d');
        $this->form->period_end = Carbon::create(date('Y'), (int) date('m'))
            ->endOfMonth()
            ->format('Y-m-d');
        $this->msg = 'Buchungen holen';
        $this->form->total_income = 0;
        $this->form->total_expenditure = 0;
        $this->form->end_amount = 0;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.report.create.form');
    }
}
