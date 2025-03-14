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
        'locale'
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
