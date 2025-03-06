<?php

namespace App\Models\Membership;

use App\Enums\MemberFeeType;
use App\Enums\MemberType;
use App\Enums\TransactionStatus;
use App\Models\Accounting\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\Membership\MemberFactory> */
    use HasFactory, Notifiable;

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
        return Member::whereIn('type', [MemberType::AD->value, MemberType::MD->value])
            ->get();
    }

    public static function countNewApplicants(): int
    {
        return Member::whereIn('type', [MemberType::AP->value])
            ->get()
            ->count();
    }

    public static function Applicants()
    {
        return Member::whereIn('type', [MemberType::AP->value])
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

    public function transactions(): hasMany
    {
        return $this->hasMany(Transaction::class);
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

        $payments = MemberTransaction::where('member_id', $this->id)
            ->whereHas('transaction', function ($query) {
                $query->where('label', 'LIKE', '%beitrag%');
            })
            ->with(['transaction' => function ($query) {
                $query->select('id', 'amount_gross', 'label', 'status')
                    ->whereBetween('date', [Carbon::now('Europe/Berlin')->startOfYear(), Carbon::now('Europe/Berlin')->endOfYear()])
                    ->where('status', TransactionStatus::booked->value); // Select columns from the transaction table
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

        $invitation = Invitation::where('email', $this->email)->first();

        if ($invitation) {
            return $invitation->accepted === 1 ? 'accepted' : 'invited';
        }

        return 'none';

    }

    public function hasBirthdayToday(): bool
    {
        return $this->birth_date->format('d') === Carbon::today('Europe/Berlin')->format('d');
    }

    public function birthDayInMonth(): string
    {

        return Carbon::create(date('Y'), $this->birth_date->format('m'), $this->birth_date->format('d'))
            ->isoFormat('Do dddd');

    }

    public function age(): int
    {
        return (int) $this->birth_date->diffInYears();
    }
}
