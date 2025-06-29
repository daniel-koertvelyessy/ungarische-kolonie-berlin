<?php

declare(strict_types=1);

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
        Schema::create('event_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->index();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('brings_guests')->default(false);
            $table->boolean('consentNotification')->default(false);
            $table->unsignedTinyInteger('amount_guests')->default(0);
            $table->foreignIdFor(\App\Models\Event\Event::class);
            $table->unique(['event_id', 'email']);
            $table->timestamp('confirmed_at')->nullable(); // Für die Bestätigung
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_subscriptions');
    }
};
