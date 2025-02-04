<?php

use App\Models\Accounting\Account;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->unsignedInteger('amount_net');
            $table->unsignedtinyInteger('vat');
            $table->unsignedInteger('tax')->nullable();
            $table->unsignedInteger('amount_gross');
            $table->foreignIdFor(Account::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\Accounting\Receipt::class)->nullable()->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\Accounting\BookingAccount::class)->nullable();
            $table->enum('type', \App\Enums\TransactionType::toArray());
            $table->enum('status', \App\Enums\TransactionStatus::toArray());
            $table->timestamps();
        });
    }

};
