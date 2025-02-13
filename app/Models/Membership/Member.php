<?php

namespace App\Models\Membership;

use App\Enums\MemberType;
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
    use Notifiable;

    /** @use HasFactory<\Database\Factories\Membership\MemberFactory> */
    use HasFactory;

    public static float $fee = 500;

    public static int $minimumAgeForDeduction = 65;

    protected $guarded = [];


    protected $casts = [
        'applied_at' => 'datetime',
        'verified_at' => 'datetime',
        'entered_at' => 'datetime',
        'left_at' => 'datetime',
        'is_deducted' => 'boolean',
    ];

    public function fullName(): string
    {
        return $this->name.', '.$this->first_name;
    }

    public static function feeForHumans(): string
    {
        return number_format(Member::$fee, 2, ',', '.');
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

    public function transactions(): hasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function feeStatus(): array
    {
        if ($this->is_deducted){
            return [
                'paid' => $this->totalFee,
                'status' => true
            ];
        }
        $paidFee = 0;

        $payments = MemberTransaction::where('member_id', $this->id)
            ->whereHas('transaction', function ($query) {
                $query->where('label', 'LIKE', '%beitrag%')->where('label', 'LIKE', '%'.date('Y').'%');
            })
            ->with(['transaction' => function ($query) {
                $query->select('id', 'amount_gross', 'label'); // Select columns from the transaction table
            }])
            ->whereBetween('updated_at', [
                Carbon::today()->startOfYear(), Carbon::now()
            ])
            ->get();

        $totalFee = Member::$fee * 12;
        foreach ($payments as $payment) {
            $paidFee += $payment->transaction->amount_gross;
        }

        return ['paid' => $paidFee, 'status' => $paidFee >= $totalFee];
    }

}
