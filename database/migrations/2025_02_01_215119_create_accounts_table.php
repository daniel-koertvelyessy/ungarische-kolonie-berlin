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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('number')->unique()->index();
            $table->enum('type',\App\Enums\AccountType::toArray());
            $table->string('institute')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->integer('starting_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
