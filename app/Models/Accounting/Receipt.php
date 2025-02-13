<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    /** @use HasFactory<\Database\Factories\ReceiptFactory> */
    use HasFactory;

    protected $guarded=[];

    public function transaction(): BelongsTo
    {
        return $this->BelongsTo(Transaction::class);
    }

    public function download()
    {
        $this->file_name;
    }
}
