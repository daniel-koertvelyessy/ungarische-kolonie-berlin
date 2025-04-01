<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /** @use HasFactory<\Database\Factories\HistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'historable_id',
        'historable_type',
        'user_id',
        'action',
        'changes',
        'changed_at',
        'created_at',
        'updated_at',
    ];
}
