<?php

use App\Enums\TransactionStatus;
use App\Models\Accounting\Transaction;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancel_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('reason');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Transaction::class);
            $table->enum('status', TransactionStatus::toArray())->default(TransactionStatus::submitted->value);
        });
    }
};
