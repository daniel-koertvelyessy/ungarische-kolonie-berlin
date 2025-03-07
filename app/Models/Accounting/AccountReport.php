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

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $starting_amount
 * @property int $end_amount
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $period_start
 * @property \Illuminate\Support\Carbon $period_end
 * @property int $total_income
 * @property int $total_expenditure
 * @property string $status
 * @property string|null $notes
 * @property-read \App\Models\Accounting\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\AccountReportAudit> $audits
 * @property-read int|null $audits_count
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereEndAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereStartingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereTotalExpenditure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReport whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
