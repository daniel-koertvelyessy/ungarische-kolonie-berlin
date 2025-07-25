<?php

declare(strict_types=1);

use App\Enums\BookingAccountType;
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
        Schema::create('booking_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('type', BookingAccountType::toArray());
            $table->string('number')->unique()->index();
            $table->string('label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_accounts');
    }
};
