<?php

namespace App\Models\Membership;

use App\Enums\MemberFeeType;
use App\Enums\MemberType;
use App\Enums\TransactionStatus;
use App\Models\Accounting\Transaction;
use App\Models\Traits\HasHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon $applied_at
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $entered_at
 * @property \Illuminate\Support\Carbon|null $left_at
 * @property bool $is_deducted
 * @property string|null $deduction_reason
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string $name
 * @property string|null $first_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $country
 * @property string|null $locale
 * @property string|null $gender
 * @property string $type
 * @property int|null $user_id
 * @property string|null $birth_place
 * @property string|null $citizenship
 * @property string|null $family_status
 * @property string $fee_type
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read User|null $user
 *
 * @method static \Database\Factories\Membership\MemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereAppliedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereDeductionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEnteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereFamilyStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereIsDeducted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereLeftAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereZip($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\History> $histories
 * @property-read int|null $histories_count
 * @property-read \App\Models\Membership\MemberRole|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership\Role> $activeRoles
 * @property-read int|null $active_roles_count
 *
 * @mixin \Eloquent
 */
class Member extends Model
{
    /** @use HasFactory<\Database\Factories\Membership\MemberFactory> */
    use HasFactory, Notifiable;

    use HasHistory;

    public static int $age_discounted = 65;

    public static int $age_free = 80;

    protected $guarded = [];

    protected $casts = [
        'applied_at' => 'datetime',
        'verified_at' => 'datetime',
        'entered_at' => 'datetime',
        'left_at' => 'datetime',
        'birth_date' => 'datetime',
        'is_deducted' => 'boolean',
    ];

    public function fullName(): string
    {
        return $this->name.', '.$this->first_name;
    }

    public static function feeForHumans(int $value): string
    {
        return number_format($value / 100, 2, ',', '.');
    }

    public static function getBoardMembers(): object
    {
        return Member::query()->whereIn('type', [MemberType::AD->value, MemberType::MD->value])
            ->get();
    }

    public static function countNewApplicants(): int
    {
        return Member::query()->whereIn('type', [MemberType::AP->value])
            ->count();
    }

    public static function Applicants(): \Illuminate\Database\Eloquent\Collection
    {
        return Member::query()->whereIn('type', [MemberType::AP->value])
            ->get();
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasUser(): bool
    {

        if ($this->user->hasAttribute('email')) {
            if ($this->user->email) {
                return true;
            }
        }

        return false;
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasManyThrough|\Illuminate\Database\Eloquent\Builder
    {
        //        return $this->hasMany(Transaction::class);
        return $this->hasManyThrough(Transaction::class, MemberTransaction::class, 'member_id', 'id', 'id', 'transaction_id');
    }

    public function feeStatus(): array
    {
        $totalFee = MemberFeeType::fee($this->fee_type) * 12;

        //        if ($this->fee_type === MemberFeeType::FREE->value){
        //            return [
        //                'paid' => $totalFee,
        //                'total' => $totalFee,
        //                'status' => true
        //            ];
        //        }
        $paidFee = 0;
        $currentYear = Carbon::now('Europe/Berlin')->year;
        $payments = MemberTransaction::query()
            ->where('member_id', $this->id)
            ->with(['transaction' => function ($query) {
                $query->select('id', 'amount_gross', 'label', 'status')
                    ->whereBetween('date', [Carbon::now('Europe/Berlin')->startOfYear(), Carbon::now('Europe/Berlin')->endOfYear()])
                    ->where('booking_account_id', '=', 13)
                    ->where('status', TransactionStatus::booked->value)
                    ->orWhere('label', 'LIKE', '%'.Carbon::now('Europe/Berlin')->year.'%')
                    ->orWhere('label', 'LIKE', '%betrag%'); // Select columns from the transaction table
            }])
            ->whereBetween('updated_at', [
                Carbon::today()->startOfYear(), Carbon::now('Europe/Berlin'),
            ])
            ->get();

        foreach ($payments as $payment) {
            if ($payment->transaction) {
                $paidFee += $payment->transaction->amount_gross;
            }
        }

        return ['paid' => $paidFee / 100, 'total' => $totalFee / 100, 'status' => $paidFee >= $totalFee];
    }

    public function checkInvitationStatus(): string
    {

        $invitation = Invitation::query()->where('email', $this->email)->first();

        if ($invitation) {
            return $invitation->accepted ? 'accepted' : 'invited';
        }

        return 'none';

    }

    public function hasBirthdayToday(): bool
    {
        return $this->birth_date->format('d') === Carbon::today('Europe/Berlin')->format('d');
    }

    public function birthDayInMonth(): string
    {

        return Carbon::create(date('Y'), (int) $this->birth_date->format('m'), (int) $this->birth_date->format('d'))
            ->isoFormat('Do dddd');

    }

    public function age(): int
    {
        return (int) $this->birth_date->diffInYears();
    }

    /**
     * The roles that belong to the member.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'member_role') // Matches convention
            ->withPivot('designated_at', 'resigned_at', 'about_me', 'profile_image')
            ->withTimestamps()
            ->using(MemberRole::class)
            ->orderBy('roles.sort', 'asc');
    }

    /**
     * The active roles that belong to the member.
     */
    public function activeRoles(): BelongsToMany
    {
        return $this->roles()->wherePivot('resigned_at', null);
    }
}
