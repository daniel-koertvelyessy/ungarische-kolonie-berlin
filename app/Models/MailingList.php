<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property int|null $member_id
 *
 * @method static \Database\Factories\MailingListFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereUpdatedAt($value)
 *
 * @property bool $terms_accepted
 * @property bool $update_on_events
 * @property bool|null $update_on_articles
 * @property bool|null $update_on_notifications
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property string|null $verification_token
 * @property \App\Enums\Locale|null $locale
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereTermsAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereUpdateOnArticles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereUpdateOnEvents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereUpdateOnNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailingList whereVerifiedAt($value)
 *
 * @mixin \Eloquent
 */
class MailingList extends Model
{
    /** @use HasFactory<\Database\Factories\MailingListFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'terms_accepted',
        'update_on_events',
        'update_on_articles',
        'update_on_notifications',
        'verified_at',
        'verification_token',
        'locale',
    ];

    protected $hidden = ['verification_token'];

    protected $casts = [
        'verified_at' => 'datetime',
        'terms_accepted' => 'boolean',
        'update_on_events' => 'boolean',
        'update_on_articles' => 'boolean',
        'update_on_notifications' => 'boolean',
        'locale' => \App\Enums\Locale::class,
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->verification_token = Str::random(40); // Generate token on signup
        });
    }

    public function verify()
    {
        $this->update([
            'verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function generateNewToken()
    {
        $this->update(['verification_token' => Str::random(40)]);

        return $this->verification_token;
    }
}
