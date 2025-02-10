<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable =[
        'email',
        'token',
        'accepted',
    ];

    public function invite(){

    }
}
