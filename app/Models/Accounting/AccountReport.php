<?php

namespace App\Models\Accounting;

use App\Enums\ReportStatus;
use App\Livewire\Traits\HasPrivileges;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

final class AccountReport extends Model
{
    /** @use HasFactory<\Database\Factories\AccountReportFactory> */
    use HasFactory, HasPrivileges;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'starting_amount' => 'integer',
            'end_amount' => 'integer',
            'total_income' => 'integer',
            'total_expenditure' => 'integer',
            'period_start' => 'date',
            'period_end' => 'date',
        ];
    }

    public function audits(): HasMany
    {
        return $this->hasMany(AccountReportAudit::class, 'account_report_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function checkAuditStatus(): bool
    {
        return $this->getReportAudits()->count() > 0;
    }

    public function getReportAudits()
    {
        return AccountReportAudit::query()->where('account_report_id', '=', $this->account_id)->get();
    }

    public static function setReportStatus(int $accountReportId)
    {
        $audits = AccountReportAudit::query()->where('id', $accountReportId)->get();
        $audited_status = new Collection;

        if ($audits->count()) {
            foreach ($audits as $audit) {
                if ($audit->approved_at) {
                    $audited_status->push(true);
                }
            }
        }
        if ($audited_status->count() === $audits->count()) {
            AccountReportAudit::query()->find($accountReportId)->report()->update(['status' => ReportStatus::audited->value]);
        }

    }
}
