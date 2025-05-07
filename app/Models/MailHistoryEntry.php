<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property array<array-key, mixed> $subject
 * @property array<array-key, mixed> $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static Builder<static>|MailHistoryEntry newModelQuery()
 * @method static Builder<static>|MailHistoryEntry newQuery()
 * @method static Builder<static>|MailHistoryEntry query()
 * @method static Builder<static>|MailHistoryEntry whereCreatedAt($value)
 * @method static Builder<static>|MailHistoryEntry whereId($value)
 * @method static Builder<static>|MailHistoryEntry whereMessage($value)
 * @method static Builder<static>|MailHistoryEntry whereSubject($value)
 * @method static Builder<static>|MailHistoryEntry whereUpdatedAt($value)
 * @method static Builder<static>|MailHistoryEntry whereUserId($value)
 *
 * @property string|null $attachments
 *
 * @method static Builder<static>|MailHistoryEntry whereAttachments($value)
 *
 * @mixin Eloquent
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

    public static function checkEntry(array $valueArray): bool
    {
        return MailHistoryEntry::query()->whereJsonContains('subject', $valueArray)->exists();
    }
}
