<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    public static float $fee = 10.50;

    protected $guarded = [];


    public static function feeForHumans():string
    {
        return number_format(Member::$fee,2,',','.');
    }

}
