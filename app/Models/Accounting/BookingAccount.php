<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAccount extends Model
{
    /**
     *   Standardkontenrahmen 49
     *   https://www.standardkontenrahmen.de/skr49
     */

    /** @use HasFactory<\Database\Factories\BookingAccountFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'number',
        'type',
    ];
}
