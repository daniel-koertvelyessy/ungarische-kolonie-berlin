<?php

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
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
        Schema::create('event_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->string('label');
            $table->integer('amount');
            $table->string('name')->nullable();
            $table->foreignIdFor(Transaction::class);
            $table->foreignIdFor(\App\Models\Event::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_transactions');
    }
};
