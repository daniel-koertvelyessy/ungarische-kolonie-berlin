<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    use Notifiable;
    protected $fillable =[
        'email',
        'token',
        'accepted',
    ];

    public function invite(){

    }
}
