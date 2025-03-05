<?php

namespace App\Models\Accounting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashCount extends Model
{

    protected $guarded = [];

    protected $casts = [
        'counted_at' => 'date',
        'euro_two_hundred' => 'integer',
        'euro_one_hundred' => 'integer',
        'euro_fifty'       => 'integer',
        'euro_twenty'      => 'integer',
        'euro_ten'         => 'integer',
        'euro_five'        => 'integer',
        'euro_two'         => 'integer',
        'euro_one'         => 'integer',
        'cent_fifty'       => 'integer',
        'cent_twenty'      => 'integer',
        'cent_ten'         => 'integer',
        'cent_five'        => 'integer',
        'cent_two'         => 'integer',
        'cent_one'         => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @param  int  $cash_count_id
     * @return int //  Return Value in Euro-Cent!
     */
    public static function sumCountCents(int $cash_count_id): int
    {
        $cc = CashCount::query()
            ->findOrFail($cash_count_id);
        return
            $cc->euro_two_hundred * 20000 +
            $cc->euro_one_hundred * 10000 +
            $cc->euro_fifty * 5000 +
            $cc->euro_twenty * 2000 +
            $cc->euro_ten * 1000 +
            $cc->euro_five * 500 +
            $cc->euro_two * 200 +
            $cc->euro_one * 100 +
            $cc->cent_fifty * 50 +
            $cc->cent_twenty * 20 +
            $cc->cent_ten * 10 +
            $cc->cent_five * 5 +
            $cc->cent_two * 2 +
            $cc->cent_one * 1;
    }

    public function sumString():string
    {
        return number_format(CashCount::sumCountCents($this->id)/100,2,',','.');
    }

}
