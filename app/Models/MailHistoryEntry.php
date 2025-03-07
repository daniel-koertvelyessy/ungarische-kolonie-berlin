<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property array<array-key, mixed> $subject
 * @property array<array-key, mixed> $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailHistoryEntry whereUserId($value)
 *
 * @mixin \Eloquent
 */
class MailHistoryEntry extends Model
{
    protected $guarded = [];

    protected $casts = [
        'subject' => 'array',
        'message' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
