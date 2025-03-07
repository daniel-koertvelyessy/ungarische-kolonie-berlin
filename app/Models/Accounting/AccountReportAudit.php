<?php

namespace App\Models\Accounting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_report_id
 * @property int $user_id
 * @property bool|null $is_approved
 * @property string|null $approved_at
 * @property string|null $reason
 * @property-read \App\Models\Accounting\AccountReport $report
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereAccountReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountReportAudit whereUserId($value)
 *
 * @mixin \Eloquent
 */
class AccountReportAudit extends Model
{
    protected $fillable = [
        'account_report_id',
        'user_id',
        'is_approved',
        'reason',

    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(AccountReport::class, 'account_report_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
