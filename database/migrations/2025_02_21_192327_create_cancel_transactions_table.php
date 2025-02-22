<?php

use App\Models\Accounting\Transaction;
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
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(Transaction::class);
            $table->enum('status', \App\Enums\TransactionStatus::toArray())->default(\App\Enums\TransactionStatus::submitted->value);
        });
    }
};
