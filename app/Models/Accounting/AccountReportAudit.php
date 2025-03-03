<?php

namespace App\Models\Accounting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            'is_approved' => 'bool',
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
