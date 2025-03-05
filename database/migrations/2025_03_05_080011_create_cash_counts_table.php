<?php

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
        Schema::create('cash_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('counted_at');
            $table->string('label');
            $table->text('notes')->nullable();
            $table->integer('euro_two_hundred', false, true)->nullable();
            $table->integer('euro_one_hundred', false, true)->nullable();
            $table->integer('euro_fifty', false, true)->nullable();
            $table->integer('euro_twenty', false, true)->nullable();
            $table->integer('euro_ten', false, true)->nullable();
            $table->integer('euro_five', false, true)->nullable();
            $table->integer('euro_two', false, true)->nullable();
            $table->integer('euro_one', false, true)->nullable();
            $table->integer('cent_fifty', false, true)->nullable();
            $table->integer('cent_twenty', false, true)->nullable();
            $table->integer('cent_ten', false, true)->nullable();
            $table->integer('cent_five', false, true)->nullable();
            $table->integer('cent_two', false, true)->nullable();
            $table->integer('cent_one', false, true)->nullable();
            $table->timestamps();

        });
    }
};
