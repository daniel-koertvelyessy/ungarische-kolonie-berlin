<?php

namespace App\Models\Membership;

use App\Enums\MemberType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use Notifiable;
    /** @use HasFactory<\Database\Factories\Membership\MemberFactory> */
    use HasFactory;

    public static float $fee = 10.50;

    public static int $minimumAgeForDeduction = 65;

    protected $guarded = [];


    protected $casts = [
        'applied_at'=> 'datetime',
        'verified_at'=> 'datetime',
        'entered_at'=> 'datetime',
        'left_at'=> 'datetime',
        'is_deducted' => 'boolean',
    ];

    public function fullName():string
    {
        return $this->name . ', ' . $this->first_name;
    }

    public static function feeForHumans(): string
    {
        return number_format(Member::$fee, 2, ',', '.');
    }

    public static function getBoardMembers(): object
    {
        return Member::whereIn('type',[MemberType::AD->value, MemberType::MD->value])
            ->get();
    }


    public static function countNewApplicants(): int{
        return Member::whereIn('type',[MemberType::AP->value])
            ->get()->count();
    }
    public static function Applicants()
    {
        return Member::whereIn('type',[MemberType::AP->value])->get();
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

}
