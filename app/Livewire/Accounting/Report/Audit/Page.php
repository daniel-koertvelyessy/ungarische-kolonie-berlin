<?php

namespace App\Livewire\Accounting\Report\Audit;

use App\Enums\TransactionStatus;
use App\Models\Accounting\AccountReport;
use App\Models\Accounting\AccountReportAudit;
use App\Models\Accounting\Transaction;
use Livewire\Component;

class Page extends Component
{
    public int $accountReportAuditId;
    public $transactions;
    protected AccountReportAudit $audit;
    public AccountReport  $report;

    public function mount(int $accountReportAuditId)
    {
        $this->accountReportAuditId = $accountReportAuditId;
        $this->audit = AccountReportAudit::findOrFail($this->accountReportAuditId);

        $this->report = AccountReport::find($this->audit->account_report_id);

        $this->transactions = Transaction::where('account_id', '=', $this->report->account->id)
            ->where('status', TransactionStatus::booked->value)
            ->whereBetween('date', [$this->report->period_start, $this->report->period_end])
            ->orderBy('date')
            ->get();

    }

    public function render()
    {
        return view('livewire.accounting.report.audit.page');
    }
}
